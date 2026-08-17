<?php
declare(strict_types=1);

/* =========================================================
   SESSION
========================================================== */

session_name('ticketing_session');
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit('Unauthorized. Please log in again.');
}

/* =========================================================
   LOAD TICKET MODEL
========================================================== */

require_once __DIR__ . '/../includes/functions/ticket-function.php';

/* =========================================================
   LOAD DOMPDF
========================================================== */

require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

/* =========================================================
   VALIDATE DATE
========================================================== */

function isValidDate(string $date): bool
{
    $d = DateTime::createFromFormat('Y-m-d', $date);

    return $d && $d->format('Y-m-d') === $date;
}

/* =========================================================
   GET FILTER VALUES
========================================================== */

$from = trim((string) ($_GET['from'] ?? ''));
$to = trim((string) ($_GET['to'] ?? ''));
$sort = trim((string) ($_GET['sort'] ?? 'latest'));

if (
    $from === '' ||
    $to === '' ||
    !isValidDate($from) ||
    !isValidDate($to)
) {
    http_response_code(400);
    exit('Invalid or missing "from"/"to" date. Format: YYYY-MM-DD');
}

if ($from > $to) {
    http_response_code(400);
    exit('"from" date cannot be later than "to" date.');
}

if (!in_array($sort, ['oldest', 'latest'], true)) {
    $sort = 'latest';
}

/* =========================================================
   FETCH RESOLVED TICKETS
========================================================== */

$ticketModel = new Ticket($db);

$tickets = $ticketModel->getResolvedTicketsByDateRange(
    $from,
    $to,
    $sort
);

/* =========================================================
   HTML ESCAPE
========================================================== */

function h(?string $value): string
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

/* =========================================================
   FORMAT DATE TIME
========================================================== */

function fmt(?string $value): string
{
    if (!$value) {
        return '—';
    }

    $d = DateTime::createFromFormat(
        'Y-m-d H:i:s',
        $value
    ) ?: new DateTime($value);

    return $d->format('M d, Y g:i A');
}

/* =========================================================
   SORT LABEL
========================================================== */

$sortLabel = $sort === 'oldest'
    ? 'Oldest to Latest'
    : 'Latest to Oldest';

/* =========================================================
   LOGO
========================================================== */

function getLogoDataUri(): string
{
    $logoPath = __DIR__ . '/../assets/logo/logo2.png';

    if (!file_exists($logoPath)) {
        return '';
    }

    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
    $data = file_get_contents($logoPath);

    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

$logoDataUri = getLogoDataUri();

$logoImgTag = $logoDataUri !== ''
    ? '<img src="' . $logoDataUri . '" class="logo">'
    : '';

/* =========================================================
   BUILD TABLE ROWS
========================================================== */

$rowsHtml = '';

if (empty($tickets)) {
    $rowsHtml = '
        <tr>
            <td colspan="10" class="empty">
                No resolved tickets found for the selected date range.
            </td>
        </tr>
    ';
} else {
    foreach ($tickets as $t) {
        $rowsHtml .=
            '<tr>' .
                '<td>#' . h((string) $t['ticket_id']) . '</td>' .
                '<td>' . h($t['status']) . '</td>' .
                '<td>' . h($t['username']) . '</td>' .
                '<td>' . h($t['department']) . '</td>' .
                '<td>' . h($t['subject']) . '</td>' .
                '<td>' . h($t['description']) . '</td>' .
                '<td>' . h($t['priority']) . '</td>' .
                '<td>' . h($t['resolution']) . '</td>' .
                '<td>' . h(fmt($t['created_at'])) . '</td>' .
                '<td>' . h(fmt($t['resolve_at'])) . '</td>' .
            '</tr>';
    }
}

/* =========================================================
   GENERATED DATE
========================================================== */

$generatedAt = (new DateTime())->format('M d, Y g:i A');

/* =========================================================
   PDF HTML
========================================================== */

$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page {
        margin: 20px 24px;
    }

    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 10px;
        color: #1f2937;
    }

    .header {
        margin-bottom: 14px;
        width: 100%;
        overflow: hidden;
    }

    .header .logo {
        float: left;
        width: 120px;
        height: auto;
        margin-right: 12px;
        object-fit: contain;
    }

    .header .header-text {
        overflow: hidden;
        padding-top: 4px;
    }

    .header h1 {
        font-size: 16px;
        margin: 0 0 4px 0;
        color: #14532d;
    }

    .header p {
        margin: 0;
        font-size: 10px;
        color: #6b7280;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        background: #f0fdf4;
        color: #166534;
        font-size: 8.5px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        text-align: left;
        padding: 6px 6px;
        border-bottom: 1px solid #d1d5db;
    }

    tbody td {
        font-size: 9px;
        padding: 6px 6px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: top;
    }

    tbody tr:nth-child(even) {
        background: #fafafa;
    }

    td.empty {
        text-align: center;
        padding: 20px;
        color: #6b7280;
    }

    .footer {
        margin-top: 10px;
        font-size: 8px;
        color: #9ca3af;
        text-align: right;
    }
</style>
</head>

<body>

    <div class="header">
        {$logoImgTag}

        <div class="header-text">
            <h1>Ticket Report | Resolved Tickets</h1>

            <p>
                Date Range: {$from} to {$to}
                &nbsp;|&nbsp;
                Sort: {$sortLabel}
                &nbsp;|&nbsp;
                Generated: {$generatedAt}
            </p>
        </div>
    </div>

    <table>

        <thead>

            <tr>
                <th>Ticket ID</th>
                <th>Status</th>
                <th>Name</th>
                <th>Department</th>
                <th>Issue Subject</th>
                <th>Issue Details</th>
                <th>Priority</th>
                <th>Resolution</th>
                <th>Ticket At</th>
                <th>Resolve At</th>
            </tr>

        </thead>

        <tbody>
            {$rowsHtml}
        </tbody>

    </table>

    <div class="footer">
        Ticketing System &mdash; Auto-generated report
    </div>

</body>
</html>
HTML;

/* =========================================================
   DOMPDF
========================================================== */

$options = new Options();

$options->set(
    'isHtml5ParserEnabled',
    true
);

$options->set(
    'isRemoteEnabled',
    false
);

$options->set(
    'defaultFont',
    'DejaVu Sans'
);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper(
    'A4',
    'landscape'
);

$dompdf->render();

/* =========================================================
   PDF OUTPUT
========================================================== */

$filename =
    'ticket-report_' .
    $from .
    '_to_' .
    $to .
    '_' .
    $sort .
    '.pdf';

$dompdf->stream(
    $filename,
    [
        'Attachment' => false
    ]
);