<?php
declare(strict_types=1);

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

$ticketModel = new Ticket($db);

/* =========================================================
   JSON RESPONSE
========================================================== */

function respond(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode($payload);
    exit;
}

/* =========================================================
   GET INPUT
========================================================== */

function getInput(): array
{
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (is_array($json)) {
        return $json + $_POST + $_GET;
    }

    return $_POST + $_GET;
}

/* =========================================================
   VALIDATE DATE
========================================================== */

function isValidDate(string $date): bool
{
    $d = DateTime::createFromFormat('Y-m-d', $date);

    return $d && $d->format('Y-m-d') === $date;
}

/* =========================================================
   ROUTING
========================================================== */

$input = getInput();
$action = $input['action'] ?? ($_GET['action'] ?? '');

try {
    switch ($action) {

        /* =====================================================
           LIST
        ====================================================== */

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
                'data' => $allTickets,
                'total' => count($allTickets),
                'max_id' => $maxId
            ]);
        }

        /* =====================================================
           FILTER
        ====================================================== */

        case 'filter': {
            $from = trim((string) ($input['from'] ?? ''));
            $to = trim((string) ($input['to'] ?? ''));
            $sort = trim((string) ($input['sort'] ?? 'latest'));

            if ($from === '' || $to === '') {
                respond([
                    'success' => false,
                    'message' => 'Kailangan ng From at To date.'
                ], 400);
            }

            if (!isValidDate($from) || !isValidDate($to)) {
                respond([
                    'success' => false,
                    'message' => 'Invalid date format.'
                ], 400);
            }

            if ($from > $to) {
                respond([
                    'success' => false,
                    'message' => 'Ang From date ay hindi pwedeng mas huli sa To date.'
                ], 400);
            }

            if (!in_array($sort, ['oldest', 'latest'], true)) {
                $sort = 'latest';
            }

            $filtered = $ticketModel->getResolvedTicketsByDateRange(
                $from,
                $to,
                $sort
            );

            respond([
                'success' => true,
                'data' => $filtered,
                'total' => count($filtered),
                'sort' => $sort
            ]);
        }

        /* =====================================================
           UNKNOWN ACTION
        ====================================================== */

        default:
            respond([
                'success' => false,
                'message' => 'Unknown action.'
            ], 400);
    }

} catch (Throwable $e) {
    respond([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ], 500);
}