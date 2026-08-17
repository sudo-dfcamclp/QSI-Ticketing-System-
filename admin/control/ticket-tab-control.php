<?php

/* =============================================================
   TICKET TAB CONTROL
   -------------------------------------------------------------
   Ito ang AJAX/JSON API endpoint ng Ticket Tab. TINATAWAG ITO
   NG ticket-tab.js (via fetch) — HINDI ito yung pinapa-fetch ng
   tab-manager.js para i-inject sa loob ng tab (yun ay
   admin/ticket-tab.php pa rin, HTML lang). Ang control file
   na ito ay JSON lang ang output, ginagamit para sa:

     - Paglo-load ng listahan ng tickets (initial + refresh)
     - Realtime polling ng mga BAGONG ticket (walang reload)
     - Pag-fetch ng "latest" data ng isang ticket pag ni-click
       yung dropdown/toggle (para laging up-to-date agad)
     - Pag-submit ng response/resolution
     - Full CRUD (create / update / delete / update status)

   Ginagamit nito yung reusable na Ticket class mula sa
   includes/functions/ticket-function.php — hindi na natin
   binago ang class na yun, dito lang natin siya tinatawag.
============================================================== */

declare(strict_types=1);

// Session check na JSON ang response (hindi redirect) kasi
// AJAX ang tumatawag dito, hindi direktang browser navigation.
//
// Hiwalay na session name para sa Ticketing system — para
// hindi mag-share ng session cookie/state sa ibang app
// (hal. epayroll) na naka-host din sa parehong domain.
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
   (para gumana ito kahit fetch() na may JSON body ang tawag,
   o kaya plain query string lang)
============================================================== */
function getInput(): array
{
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (is_array($json)) {
        return $json + $_POST + $_GET;
    }

    return $_POST + $_GET;
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
           LIST — kunin lahat ng tickets (may pagination)
           GET ticket-tab-control.php?action=list&page=1&per_page=10
        ---------------------------------------------------- */
        case 'list': {
            $page    = max(1, (int) ($input['page'] ?? 1));
            $perPage = max(1, (int) ($input['per_page'] ?? 10));

            $allTickets = $ticketModel->getAllTickets();

            // Pinaka-mataas na ticket_id sa BUONG list (kasama pa rin
            // ang Resolved) — ginagamit ng frontend bilang "since_id"
            // checkpoint para sa susunod na realtime poll, kaya dapat
            // hindi ito naaapektuhan ng pag-alis ng Resolved sa listahan.
            $maxId = 0;
            foreach ($allTickets as $t) {
                if ((int) $t['ticket_id'] > $maxId) {
                    $maxId = (int) $t['ticket_id'];
                }
            }

            // Tapos na ang isang ticket pag Resolved na ito (na-submit
            // na ang response), kaya hindi na ito dapat mag-display sa
            // ticket-tab.php — inaalis dito sa listahan, hindi lang sa
            // frontend, para consistent kahit anong page/refresh.
            $visibleTickets = array_values(array_filter(
                $allTickets,
                fn($t) => strtolower((string) $t['status']) !== 'resolved'
            ));

            $total      = count($visibleTickets);
            $totalPages = (int) max(1, ceil($total / $perPage));

            $offset = ($page - 1) * $perPage;
            $pageItems = array_slice($visibleTickets, $offset, $perPage);

            respond([
                'success'     => true,
                'data'        => $pageItems,
                'total'       => $total,
                'page'        => $page,
                'per_page'    => $perPage,
                'total_pages' => $totalPages,
                'max_id'      => $maxId
            ]);
        }

        /* ---------------------------------------------------
           POLL — REALTIME CHECK FOR NEW TICKETS
           Tinatawag paulit-ulit (setInterval) ng ticket-tab.js.
           Ibinabalik lang ang mga ticket na mas bago pa sa
           huling nakitang ticket_id (since_id) kaya mabilisang
           JSON lang ang laman, hindi buong table.
           GET ticket-tab-control.php?action=poll&since_id=25
        ---------------------------------------------------- */
        case 'poll': {
            $sinceId = (int) ($input['since_id'] ?? 0);

            $allTickets = $ticketModel->getAllTickets();

            $newTickets = array_values(array_filter(
                $allTickets,
                fn($t) => (int) $t['ticket_id'] > $sinceId
            ));

            $maxId = $sinceId;
            foreach ($allTickets as $t) {
                if ((int) $t['ticket_id'] > $maxId) {
                    $maxId = (int) $t['ticket_id'];
                }
            }

            respond([
                'success' => true,
                'data'    => $newTickets,
                'max_id'  => $maxId,
                'count'   => count($newTickets)
            ]);
        }

        /* ---------------------------------------------------
           GET — kunin ang PINAKA-BAGONG data ng isang ticket.
           Ito yung tinatawag pag ni-click yung dropdown/toggle
           kaya laging "realtime" (fresh mula DB) ang lumalabas
           kahit may bagong update na ibang tao.
           GET ticket-tab-control.php?action=get&id=12
        ---------------------------------------------------- */
        case 'get': {
            $ticketId = (int) ($input['id'] ?? 0);

            if ($ticketId <= 0) {
                respond(['success' => false, 'message' => 'Invalid ticket id.'], 400);
            }

            $ticket = $ticketModel->getTicketById($ticketId);

            if (!$ticket) {
                respond(['success' => false, 'message' => 'Ticket not found.'], 404);
            }

            respond(['success' => true, 'data' => $ticket]);
        }

        /* ---------------------------------------------------
           CREATE — bagong ticket
        ---------------------------------------------------- */
        case 'create': {
            $username    = trim((string) ($input['username'] ?? ''));
            $department  = trim((string) ($input['department'] ?? ''));
            $subject     = trim((string) ($input['subject'] ?? ''));
            $description = trim((string) ($input['description'] ?? ''));
            $priority    = trim((string) ($input['priority'] ?? 'Normal'));
            $status      = trim((string) ($input['status'] ?? 'Pending'));

            if ($username === '' || $department === '' || $subject === '' || $description === '') {
                respond(['success' => false, 'message' => 'Missing required fields.'], 400);
            }

            $ok = $ticketModel->createTicket(
                $username,
                $department,
                $subject,
                $description,
                $priority,
                $status
            );

            respond([
                'success' => $ok,
                'message' => $ok ? 'Ticket created.' : 'Failed to create ticket.'
            ]);
        }

        /* ---------------------------------------------------
           UPDATE — i-edit ang ticket
        ---------------------------------------------------- */
        case 'update': {
            $ticketId    = (int) ($input['ticket_id'] ?? 0);
            $department  = trim((string) ($input['department'] ?? ''));
            $subject     = trim((string) ($input['subject'] ?? ''));
            $description = trim((string) ($input['description'] ?? ''));
            $priority    = trim((string) ($input['priority'] ?? ''));
            $status      = trim((string) ($input['status'] ?? ''));
            $resolution  = $input['resolution'] ?? null;

            if ($ticketId <= 0) {
                respond(['success' => false, 'message' => 'Invalid ticket id.'], 400);
            }

            $ok = $ticketModel->updateTicket(
                $ticketId,
                $department,
                $subject,
                $description,
                $priority,
                $status,
                $resolution !== null ? (string) $resolution : null
            );

            respond([
                'success' => $ok,
                'message' => $ok ? 'Ticket updated.' : 'Failed to update ticket.'
            ]);
        }

        /* ---------------------------------------------------
           UPDATE STATUS — bilis na status change lang
           (e.g. Open -> Pending -> Resolved)
        ---------------------------------------------------- */
        case 'update_status': {
            $ticketId = (int) ($input['ticket_id'] ?? 0);
            $status   = trim((string) ($input['status'] ?? ''));

            if ($ticketId <= 0 || $status === '') {
                respond(['success' => false, 'message' => 'Missing ticket id or status.'], 400);
            }

            $ok = $ticketModel->updateStatus($ticketId, $status);

            respond([
                'success' => $ok,
                'message' => $ok ? 'Status updated.' : 'Failed to update status.'
            ]);
        }

        /* ---------------------------------------------------
           SUBMIT RESPONSE / RESOLVE
           Ito yung tinatawag ng "Submit" button sa loob ng
           expandable panel (dating tumatawag diretso sa
           ticket-function.php — ngayon dito na dumadaan).
           Ginagamit ang resolveTicket() ng Ticket class kasi
           wala namang hiwalay na "response" column sa table;
           yung message ang nagiging resolution, status ->
           Resolved, at naka-set ang resolve_at = NOW().
        ---------------------------------------------------- */
        case 'submit_response': {
            $ticketId = (int) ($input['ticket_id'] ?? 0);
            $message  = trim((string) ($input['message'] ?? ''));
            $priority = trim((string) ($input['priority'] ?? ''));

            if ($ticketId <= 0 || $message === '') {
                respond(['success' => false, 'message' => 'Missing ticket id or message.'], 400);
            }

            // Priority dropdown (Low/High/Critical) sa tabi ng
            // "Response" label — whitelist para safe, kung
            // invalid/wala lang, hindi ito babaguhin.
            $allowedPriorities = ['Low', 'High', 'Critical'];

            if (!in_array($priority, $allowedPriorities, true)) {
                $priority = null;
            }

            $ok = $ticketModel->resolveTicket($ticketId, $message, $priority);

            if (!$ok) {
                respond(['success' => false, 'message' => 'Failed to submit response.'], 500);
            }

            // Ibalik yung fresh na record para pwedeng agad i-render
            // sa DOM ng frontend (status badge, resolution, atbp.)
            $ticket = $ticketModel->getTicketById($ticketId);

            respond([
                'success' => true,
                'message' => 'Response sent.',
                'data'    => $ticket
            ]);
        }

        /* ---------------------------------------------------
           DELETE — tanggalin ang ticket
        ---------------------------------------------------- */
        case 'delete': {
            $ticketId = (int) ($input['ticket_id'] ?? 0);

            if ($ticketId <= 0) {
                respond(['success' => false, 'message' => 'Invalid ticket id.'], 400);
            }

            $ok = $ticketModel->deleteTicket($ticketId);

            respond([
                'success' => $ok,
                'message' => $ok ? 'Ticket deleted.' : 'Failed to delete ticket.'
            ]);
        }

        /* ---------------------------------------------------
           STATS — (optional) counts para sa dashboard/badges
        ---------------------------------------------------- */
        case 'stats': {
            respond([
                'success' => true,
                'data' => [
                    'total'     => $ticketModel->countTickets(),
                    'open'      => $ticketModel->countByStatus('Open'),
                    'pending'   => $ticketModel->countByStatus('Pending'),
                    'resolved'  => $ticketModel->countByStatus('Resolved')
                ]
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