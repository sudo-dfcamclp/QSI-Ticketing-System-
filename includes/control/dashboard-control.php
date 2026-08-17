<?php

/* =============================================================
   DASHBOARD CONTROL
   -------------------------------------------------------------
   AJAX/JSON API endpoint ng Dashboard. Tinatawag ito ng
   dashboard.js via fetch para i-realtime ang mga stat cards
   at charts sa dashboard.php.
============================================================== */

declare(strict_types=1);

session_name('ticketing_session');
session_start();

header(
    'Content-Type: application/json; charset=utf-8'
);

if (!isset($_SESSION['user_id'])) {

    http_response_code(401);

    echo json_encode([
        'success' => false,
        'message' =>
            'Unauthorized. Please log in again.'
    ]);

    exit;
}

require_once __DIR__ .
    '/../../includes/functions/dashboard-function.php';

/*
|--------------------------------------------------------------------------
| MODELS
|--------------------------------------------------------------------------
*/

$ticketModel = new Ticket($db);

/*
|--------------------------------------------------------------------------
| RANGE
|--------------------------------------------------------------------------
*/

$allowedRanges = [
    'week',
    'month',
    'year'
];

$range = $_GET['range'] ?? 'week';

if (!in_array($range, $allowedRanges, true)) {
    $range = 'week';
}

/*
|--------------------------------------------------------------------------
| FETCH DASHBOARD DATA
|--------------------------------------------------------------------------
*/

try {

    $data = getDashboardAnalytics(
        $ticketModel,
        $users,
        $range
    );

    echo json_encode([
        'success' => true,
        'data'    => $data
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' =>
            'Failed to fetch dashboard data'
    ]);
}