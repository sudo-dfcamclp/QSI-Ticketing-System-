<?php

/* =============================================================
   PDF.PHP — Landscape PDF Report ng Resolved Tickets (dompdf)
   -------------------------------------------------------------
   Binubuksan ito sa BAGONG TAB (window.open) galing sa Print
   button ng admin/print.php (see admin/script/print.js). Hindi
   ito AJAX/JSON endpoint — direktang nagbabalik ito ng PDF file
   (binary stream) papunta sa browser.

   Query string na kailangan:
     ?from=YYYY-MM-DD&to=YYYY-MM-DD

   Ang datos ay galing sa Ticket::getResolvedTicketsByDateRange()
   (includes/functions/ticket-function.php) — "Resolved" status
   LANG, base sa resolve_at column, sa loob ng napiling range.

   Tingnan ang DOMPDF INSTALLATION GUIDE sa chat/summary para sa
   paano i-install ang dompdf/dompdf gamit ang Composer.
============================================================== */

declare(strict_types=1);

// -----------------------------------------------------------
// 1) SESSION CHECK
//    Parehong session name gaya ng ibang bahagi ng Ticketing
//    system, para hindi ma-access ang report kung hindi naka-
//    login. Redirect papunta sa login (hindi JSON) kasi direct
//    na browser navigation ito (window.open), hindi fetch/AJAX.
// -----------------------------------------------------------
session_name('ticketing_session');
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit('Unauthorized. Please log in again.');
}

require_once __DIR__ . '/../includes/functions/ticket-function.php';

// -----------------------------------------------------------
// 2) LOAD DOMPDF
//    Kinukuha via Composer autoload. I-run ang:
//      composer require dompdf/dompdf
//    sa root ng project (kung saan ilalagay ang composer.json),
//    tapos titiyakin na ang vendor/autoload.php ay tama ang
//    landas papunta rito. (Tingnan ang guide sa summary.)
// -----------------------------------------------------------
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// -----------------------------------------------------------
// 3) VALIDATE FILTER (From / To)
// -----------------------------------------------------------
function isValidDate(string $date): bool
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

$from = trim((string) ($_GET['from'] ?? ''));
$to   = trim((string) ($_GET['to'] ?? ''));

if ($from === '' || $to === '' || !isValidDate($from) || !isValidDate($to)) {
    http_response_code(400);
    exit('Invalid or missing "from"/"to" date. Format: YYYY-MM-DD');
}

if ($from > $to) {
    http_response_code(400);
    exit('"from" date cannot be later than "to" date.');
}

// -----------------------------------------------------------
// 4) FETCH DATA — Resolved tickets lang, sa loob ng date range
// -----------------------------------------------------------
$ticketModel = new Ticket($db);
$tickets     = $ticketModel->getResolvedTicketsByDateRange($from, $to);

// -----------------------------------------------------------
// 5) HELPERS (escaping + date formatting para sa HTML ng PDF)
// -----------------------------------------------------------
function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function fmt(?string $value): string
{
    if (!$value) return '—';
    $d = DateTime::createFromFormat('Y-m-d H:i:s', $value) ?: (new DateTime($value));
    return $d->format('M d, Y g:i A');
}

// -----------------------------------------------------------
// 5b) LOGO — i-embed bilang base64 (data URI)
//     -------------------------------------------------------
//     Ginagawa itong base64 (hindi direktang <img src="path">
//     o URL) dahil naka-off ang isRemoteEnabled para sa
//     seguridad, kaya hindi rin siya makaka-fetch ng file sa
//     labas ng script. Embedded base64 ang pinaka-sigurado at
//     mabilis na paraan para dumisplay ang logo sa PDF.
// -----------------------------------------------------------
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
$logoImgTag  = $logoDataUri !== ''
    ? '<img src="' . $logoDataUri . '" class="logo">'
    : '';

// -----------------------------------------------------------
// 6) BUILD THE TABLE ROWS (HTML na ipapakain kay dompdf)
// -----------------------------------------------------------
$rowsHtml = '';

if (empty($tickets)) {
    $rowsHtml = '<tr><td colspan="10" class="empty">No resolved tickets found for the selected date range.</td></tr>';
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

// -----------------------------------------------------------
// 7) FULL HTML DOCUMENT (dompdf renders plain HTML/CSS — walang
//    Tailwind classes dito dahil walang browser/CDN si dompdf;
//    plain inline <style> lang ang gagana)
// -----------------------------------------------------------
$generatedAt = (new DateTime())->format('M d, Y g:i A');

$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 20px 24px; }

    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 10px;
        color: #1f2937;
    }

    .header {
        margin-bottom: 14px;
        width: 100%;
        overflow: hidden; /* para gumana ang float layout sa dompdf */
    }

    .header .logo {
        float: left;
        width: 120px;
        height: auto;
        margin-right: 12px;
        object-fit: contain;
    }

    .header .header-text {
        overflow: hidden; /* natural na "flex" effect gamit ang float+overflow, dahil limited ang flexbox support ng dompdf */
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
            <h1>Ticket Report — Resolved Tickets</h1>
            <p>Date Range: {$from} to {$to} &nbsp;|&nbsp; Generated: {$generatedAt}</p>
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

// -----------------------------------------------------------
// 8) RENDER WITH DOMPDF — LANDSCAPE
// -----------------------------------------------------------
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', false);
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// 'inline' = ipapakita sa bagong tab; palitan ng 'attachment'
// kung gusto mong direktang mag-download.
$filename = 'ticket-report_' . $from . '_to_' . $to . '.pdf';
$dompdf->stream($filename, ['Attachment' => false]);