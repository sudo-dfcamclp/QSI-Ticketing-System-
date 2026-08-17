<?php

/*
|--------------------------------------------------------------------------
| DASHBOARD FUNCTIONS
|--------------------------------------------------------------------------
| Reusable, fetch-only functions para sa dashboard analytics.
| Ginagamit nito ang EXISTING na Ticket class (includes/functions/
| ticket-function.php) at Users class (includes/functions/
| user-function.php) — hindi natin binago ang mga yun, dito lang
| tinatawag. Ang dashboard-control.php ang bahala mag-validate ng
| request; dito lang mangyayari ang pag-fetch/aggregate.
*/

require_once __DIR__ . '/ticket-function.php';
require_once __DIR__ . '/user-function.php';

/* =========================================================
   TOTAL TICKETS (lahat, kahit hindi pa resolved)
========================================================== */
function getDashboardTotalTickets(Ticket $ticketModel): int
{
    return $ticketModel->countTickets();
}

/* =========================================================
   PENDING TICKETS (status = Pending)
========================================================== */
function getDashboardPendingTickets(Ticket $ticketModel): int
{
    return $ticketModel->countByStatus('Pending');
}

/* =========================================================
   TOTAL ACTIVE TICKETS
   ---------------------------------------------------------
   Active tickets are tickets with:
   - Viewed
   - Pending

   Formula:
   Total Active = Viewed + Pending
========================================================== */
function getDashboardTotalActiveTickets(Ticket $ticketModel): int
{
    $tickets = $ticketModel->getAllTickets();

    $activeCount = 0;

    foreach ($tickets as $row) {

        $status = strtolower(trim($row['status'] ?? ''));

        if ($status === 'viewed' || $status === 'pending') {
            $activeCount++;
        }
    }

    return $activeCount;
}

/* =========================================================
   TOTAL ADMIN USERS (lahat ng laman ng users table)
========================================================== */
function getDashboardTotalAdminUsers(Users $usersModel): int
{
    return count($usersModel->getAll());
}

/* =========================================================
   PRIORITY COUNTS (Critical / High / Low)
========================================================== */
function getDashboardPriorityCounts(Ticket $ticketModel): array
{
    $tickets = $ticketModel->getAllTickets();

    $counts = [
        'critical' => 0,
        'high'     => 0,
        'low'      => 0
    ];

    foreach ($tickets as $row) {

        $priority = strtolower(trim($row['priority'] ?? ''));

        if (isset($counts[$priority])) {
            $counts[$priority]++;
        }
    }

    return $counts;
}

/* =========================================================
   LINE GRAPH BUCKET BUILDERS (Week / Month / Year)
   -----------------------------------------------------------
   Bawat isa ay nagbabalik ng [labels, resolver]. Ang resolver
   ay closure na tumatanggap ng DateTime at nagbabalik ng index
   (position sa $labels) kung saan dapat i-bucket ang ticket, o
   null kung wala sa range.
========================================================== */
function buildWeekBuckets(): array
{
    $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    $monday = new DateTime('monday this week');
    $sunday = new DateTime('sunday this week 23:59:59');

    $resolver = function (DateTime $date) use ($monday, $sunday, $labels) {

        if ($date < $monday || $date > $sunday) {
            return null;
        }

        $index = array_search($date->format('D'), $labels, true);

        return $index === false ? null : $index;
    };

    return [$labels, $resolver];
}

function buildMonthBuckets(): array
{
    $firstDay = new DateTime('first day of this month 00:00:00');
    $lastDay  = new DateTime('last day of this month 23:59:59');

    $daysInMonth = (int) $firstDay->format('t');

    $totalWeeks = (int) ceil($daysInMonth / 7);

    $labels = [];

    for ($w = 1; $w <= $totalWeeks; $w++) {
        $labels[] = "Week {$w}";
    }

    $resolver = function (DateTime $date) use ($firstDay, $lastDay) {

        if ($date < $firstDay || $date > $lastDay) {
            return null;
        }

        $dayOfMonth = (int) $date->format('j');

        return intdiv($dayOfMonth - 1, 7);
    };

    return [$labels, $resolver];
}

function buildYearBuckets(): array
{
    $labels = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec'
    ];

    $yearStart = new DateTime('first day of January this year 00:00:00');
    $yearEnd   = new DateTime('last day of December this year 23:59:59');

    $resolver = function (DateTime $date) use ($yearStart, $yearEnd) {

        if ($date < $yearStart || $date > $yearEnd) {
            return null;
        }

        return ((int) $date->format('n')) - 1;
    };

    return [$labels, $resolver];
}

/* =========================================================
   LINE GRAPH DATA - TICKET ACTIVITY PER DEPARTMENT
========================================================== */
function getDashboardTicketActivityByDepartment(
    Ticket $ticketModel,
    string $range = 'week'
): array {

    $tickets = $ticketModel->getAllTickets();

    switch ($range) {

        case 'month':
            [$labels, $resolveIndex] = buildMonthBuckets();
            break;

        case 'year':
            [$labels, $resolveIndex] = buildYearBuckets();
            break;

        case 'week':
        default:
            [$labels, $resolveIndex] = buildWeekBuckets();
            break;
    }

    $departmentData = [];

    foreach ($tickets as $row) {

        if (empty($row['created_at'])) {
            continue;
        }

        $createdAt = new DateTime($row['created_at']);

        $labelIndex = $resolveIndex($createdAt);

        if ($labelIndex === null) {
            continue;
        }

        $department = trim($row['department'] ?? '');

        if ($department === '') {
            $department = 'Others';
        }

        if (!isset($departmentData[$department])) {
            $departmentData[$department] =
                array_fill(0, count($labels), 0);
        }

        $departmentData[$department][$labelIndex]++;
    }

    $datasets = [];

    foreach ($departmentData as $department => $values) {

        $datasets[] = [
            'label' => $department,
            'data'  => $values
        ];
    }

    return [
        'labels'   => $labels,
        'datasets' => $datasets
    ];
}

/* =========================================================
   TICKETS PER DEPARTMENT (pie chart)
========================================================== */
function getDashboardTicketsPerDepartment(Ticket $ticketModel): array
{
    $tickets = $ticketModel->getAllTickets();

    $counts = [];

    foreach ($tickets as $row) {

        $department = trim($row['department'] ?? '');

        if ($department === '') {
            $department = 'Others';
        }

        if (!isset($counts[$department])) {
            $counts[$department] = 0;
        }

        $counts[$department]++;
    }

    return $counts;
}

/* =========================================================
   PERIPHERALS / TICKET CATEGORIES
   (base sa subject column)
========================================================== */
function getDashboardPeripherals(Ticket $ticketModel): array
{
    $tickets = $ticketModel->getAllTickets();

    $keywordMap = [
        'PC / Laptop' => [
            'pc',
            'laptop',
            'computer'
        ],

        'Internet' => [
            'internet',
            'wifi',
            'network',
            'lan'
        ],

        'Printer' => [
            'printer',
            'print'
        ],

        'Scanner' => [
            'scanner',
            'scan'
        ],

        'Server' => [
            'server'
        ]
    ];

    $counts = [
        'PC / Laptop' => 0,
        'Internet'    => 0,
        'Printer'     => 0,
        'Scanner'     => 0,
        'Server'      => 0,
        'Others'      => 0
    ];

    foreach ($tickets as $row) {

        $subject = strtolower(
            trim($row['subject'] ?? '')
        );

        $matched = false;

        foreach ($keywordMap as $label => $keywords) {

            foreach ($keywords as $keyword) {

                if (strpos($subject, $keyword) !== false) {

                    $counts[$label]++;
                    $matched = true;

                    break 2;
                }
            }
        }

        if (!$matched) {
            $counts['Others']++;
        }
    }

    return $counts;
}

/* =========================================================
   BAR CHART DATA
   (Critical, High, Low - in that order)
========================================================== */
function getDashboardPriorityBarChart(
    Ticket $ticketModel
): array {

    $priorityCounts =
        getDashboardPriorityCounts($ticketModel);

    return [
        'labels' => [
            'Critical',
            'High',
            'Low'
        ],

        'values' => [
            $priorityCounts['critical'],
            $priorityCounts['high'],
            $priorityCounts['low']
        ]
    ];
}

/* =========================================================
   MASTER FUNCTION
   ---------------------------------------------------------
   Tinatawag ito ng dashboard-control.php
========================================================== */
function getDashboardAnalytics(
    Ticket $ticketModel,
    Users $usersModel,
    string $range = 'week'
): array {

    return [

        'totalTickets' =>
            getDashboardTotalTickets($ticketModel),

        'totalActive' =>
            getDashboardTotalActiveTickets($ticketModel),

        'pendingTickets' =>
            getDashboardPendingTickets($ticketModel),

        'totalAdminUsers' =>
            getDashboardTotalAdminUsers($usersModel),

        'priority' =>
            getDashboardPriorityCounts($ticketModel),

        'departments' =>
            getDashboardTicketsPerDepartment($ticketModel),

        'peripherals' =>
            getDashboardPeripherals($ticketModel),

        'ticketActivity' =>
            getDashboardTicketActivityByDepartment(
                $ticketModel,
                $range
            ),

        'priorityBarChart' =>
            getDashboardPriorityBarChart($ticketModel)
    ];
}