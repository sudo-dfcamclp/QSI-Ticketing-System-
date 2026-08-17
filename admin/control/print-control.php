<?php

/* =============================================================
   PRINT CONTROL
   -------------------------------------------------------------
   Ito ang AJAX/JSON API endpoint ng Print Report tab. Tinatawag
   ito ng admin/script/print.js (via fetch) — hiwalay ito sa
   ticket-tab-control.php dahil magkaiba ang layunin nila:

     - ticket-tab-control.php  = para sa PENDING/OPEN tickets
                                  (working queue ng agent)
     - print-control.php (ITO) = para sa REPORT/PRINT view,
                                  nagpapakita ng LAHAT ng ticket
                                  (kasama status column) at
                                  nag-aabot ng FILTERED (Resolved
                                  + date range) na data papunta
                                  sa PDF generator (admin/pdf.php)

   Ginagamit din nito yung reusable na Ticket class mula sa
   includes/functions/ticket-function.php — hindi na natin
   binago ang class na yun, dito lang natin siya tinatawag.
============================================================== */

declare(strict_types=1);

// JSON ang response (hindi redirect) kasi AJAX ang tumatawag
// dito, hindi direktang browser navigation.
//
// Parehong session name gaya ng ibang control file ng Ticketing
// system para magkasing-session sila (isang beses lang mag-login).
session_name('ticketing_session');
session_start();

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized. Please log in again.'
    ]);
    exit;
}

require_once __DIR__ . '/../../includes/functions/ticket-function.php';

// $db galing sa config.php na kasama na sa ticket-function.php
$ticketModel = new Ticket($db);


/* =============================================================
   HELPER: send JSON response tapos itigil ang script
============================================================== */
function respond(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode($payload);
    exit;
}

/* =============================================================
   HELPER: kunin ang input mula sa JSON body o sa $_POST/$_GET
============================================================== */
function getInput(): array
{
    $raw  = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (is_array($json)) {
        return $json + $_POST + $_GET;
    }

    return $_POST + $_GET;
}

/* =============================================================
   HELPER: validate na 'YYYY-MM-DD' ang format ng petsa
   (galing ito sa <input type="date">, pero dinodoble-check
   pa rin natin dito sa backend)
============================================================== */
function isValidDate(string $date): bool
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}


/* =============================================================
   ROUTING
   Isang endpoint lang, kinikilala ang gawin base sa 'action'
============================================================== */
$input  = getInput();
$action = $input['action'] ?? ($_GET['action'] ?? '');

try {

    switch ($action) {

        /* ---------------------------------------------------
           LIST — REALTIME TABLE ng Print Report
           -----------------------------------------------------
           Ipinapakita LAHAT ng ticket (anuman ang status) kasama
           ang ticket_id at status column, kaya't ginagamit ang
           getAllTickets() mismo (hindi yung "visible only" na
           filtered version sa ticket-tab-control.php).

           Ginagamit din yung 'max_id' bilang checkpoint kapag
           gusto pang gawing "poll for new rows" sa frontend
           (parehong pattern gaya ng ticket-tab).

           GET print-control.php?action=list
        ---------------------------------------------------- */
        case 'list': {
            $allTickets = $ticketModel->getAllTickets();

            $maxId = 0;
            foreach ($allTickets as $t) {
                if ((int) $t['ticket_id'] > $maxId) {
                    $maxId = (int) $t['ticket_id'];
                }
            }

            respond([
                'success' => true,
                'data'    => $allTickets,
                'total'   => count($allTickets),
                'max_id'  => $maxId
            ]);
        }

        /* ---------------------------------------------------
           FILTER PREVIEW — Resolved tickets sa loob ng From/To
           -----------------------------------------------------
           HINDI ito ang gumagawa ng PDF (ginagawa yun ng
           admin/pdf.php via GET request/window.open, dahil
           file download/inline view ang kailangan, hindi JSON).
           Pero magagamit ito kung gusto mo munang i-preview sa
           table kung ilan/anong records ang mailalabas bago
           mag-generate ng PDF.

           GET print-control.php?action=filter&from=YYYY-MM-DD&to=YYYY-MM-DD
        ---------------------------------------------------- */
        case 'filter': {
            $from = trim((string) ($input['from'] ?? ''));
            $to   = trim((string) ($input['to'] ?? ''));

            if ($from === '' || $to === '') {
                respond(['success' => false, 'message' => 'Kailangan ng From at To date.'], 400);
            }

            if (!isValidDate($from) || !isValidDate($to)) {
                respond(['success' => false, 'message' => 'Invalid date format.'], 400);
            }

            if ($from > $to) {
                respond(['success' => false, 'message' => 'Ang From date ay hindi pwedeng mas huli sa To date.'], 400);
            }

            $filtered = $ticketModel->getResolvedTicketsByDateRange($from, $to);

            respond([
                'success' => true,
                'data'    => $filtered,
                'total'   => count($filtered)
            ]);
        }

        default:
            respond(['success' => false, 'message' => 'Unknown action.'], 400);
    }

} catch (Throwable $e) {
    respond([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ], 500);
}