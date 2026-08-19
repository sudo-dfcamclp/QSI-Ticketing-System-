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

// Max rows per page para sa Print Report (tugma sa TICKET_PER_PAGE
// pattern ng ticket-tab, pero hiwalay na constant dito).
const PRINT_PER_PAGE = 10;

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
           LIST — RESOLVED TICKETS ONLY
           -----------------------------------------------------
           Kunin lamang ang Resolved tickets para sa Print Report.
           May pagination, maximum 10 tickets bawat page.

           GET:
           print-control.php?action=list&page=1
        ====================================================== */

        case 'list': {

            $page = max(
                1,
                (int) ($input['page'] ?? 1)
            );

            $perPage = PRINT_PER_PAGE;

            /*
             * Kunin ang lahat ng tickets mula sa existing
             * Ticket class.
             */
            $allTickets = $ticketModel->getAllTickets();

            /*
             * IMPORTANT:
             * Resolved tickets lamang ang papayagan sa Print tab.
             *
             * Hindi kasama:
             * - Pending
             * - Viewed
             * - Open
             *
             * Resolved lamang.
             */
            $resolvedTickets = array_values(
                array_filter(
                    $allTickets,
                    function ($ticket) {

                        return strtolower(
                            trim(
                                $ticket['status'] ?? ''
                            )
                        ) === 'resolved';
                    }
                )
            );

            /*
             * Kunin ang pinakamataas na ticket ID
             * mula sa Resolved tickets.
             */
            $maxId = 0;

            foreach ($resolvedTickets as $ticket) {

                if (
                    (int) $ticket['ticket_id'] >
                    $maxId
                ) {
                    $maxId =
                        (int) $ticket['ticket_id'];
                }
            }

            /*
             * Total Resolved tickets lamang.
             */
            $total = count(
                $resolvedTickets
            );

            /*
             * Calculate total pages.
             */
            $totalPages = (int) max(
                1,
                ceil(
                    $total / $perPage
                )
            );

            /*
             * Prevent invalid page number.
             */
            $page = min(
                $page,
                $totalPages
            );

            /*
             * Calculate offset.
             */
            $offset =
                ($page - 1) *
                $perPage;

            /*
             * Get current page items.
             */
            $pageItems = array_slice(
                $resolvedTickets,
                $offset,
                $perPage
            );

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

        /* =====================================================
           FILTER — RESOLVED TICKETS BY DATE RANGE
           -----------------------------------------------------
           Resolved tickets lamang ang ibinabalik.
           May pagination din, maximum 10 bawat page.
        ====================================================== */

        case 'filter': {

            $from = trim(
                (string) (
                    $input['from'] ?? ''
                )
            );

            $to = trim(
                (string) (
                    $input['to'] ?? ''
                )
            );

            $sort = trim(
                (string) (
                    $input['sort'] ?? 'latest'
                )
            );

            /*
             * Required dates.
             */
            if (
                $from === '' ||
                $to === ''
            ) {

                respond([
                    'success' => false,
                    'message' =>
                        'Kailangan ng From at To date.'
                ], 400);
            }

            /*
             * Validate date format.
             */
            if (
                !isValidDate($from) ||
                !isValidDate($to)
            ) {

                respond([
                    'success' => false,
                    'message' =>
                        'Invalid date format.'
                ], 400);
            }

            /*
             * From date cannot be later than To date.
             */
            if ($from > $to) {

                respond([
                    'success' => false,
                    'message' =>
                        'Ang From date ay hindi pwedeng mas huli sa To date.'
                ], 400);
            }

            /*
             * Allowed sorting values only.
             */
            if (
                !in_array(
                    $sort,
                    [
                        'oldest',
                        'latest'
                    ],
                    true
                )
            ) {

                $sort = 'latest';
            }

            /*
             * Pagination.
             */
            $page = max(
                1,
                (int) (
                    $input['page'] ?? 1
                )
            );

            $perPage = PRINT_PER_PAGE;

            /*
             * Existing Ticket method:
             * Resolved tickets only, filtered by date range.
             */
            $filtered =
                $ticketModel->getResolvedTicketsByDateRange(
                    $from,
                    $to,
                    $sort
                );

            /*
             * Total filtered tickets.
             */
            $total = count(
                $filtered
            );

            /*
             * Calculate total pages.
             */
            $totalPages = (int) max(
                1,
                ceil(
                    $total / $perPage
                )
            );

            /*
             * Prevent invalid page number.
             */
            $page = min(
                $page,
                $totalPages
            );

            /*
             * Calculate offset.
             */
            $offset =
                ($page - 1) *
                $perPage;

            /*
             * Get current page.
             */
            $pageItems = array_slice(
                $filtered,
                $offset,
                $perPage
            );

            respond([
                'success'     => true,
                'data'        => $pageItems,
                'total'       => $total,
                'page'        => $page,
                'per_page'    => $perPage,
                'total_pages' => $totalPages,
                'sort'        => $sort
            ]);
        }

        /* =====================================================
           UNKNOWN ACTION
        ====================================================== */

        default:

            respond([
                'success' => false,
                'message' =>
                    'Unknown action.'
            ], 400);
    }

} catch (Throwable $e) {

    respond([
        'success' => false,
        'message' =>
            'Server error: ' .
            $e->getMessage()
    ], 500);
}