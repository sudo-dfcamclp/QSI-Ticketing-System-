<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../includes/functions/ticket-function.php';

/* =========================================================
   ONLY ACCEPT POST
========================================================== */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);
    exit;
}

/* =========================================================
   COLLECT + SANITIZE INPUT
========================================================== */
$username    = trim($_POST['username'] ?? '');
$department  = trim($_POST['department'] ?? '');
$subject     = trim($_POST['subject'] ?? '');
$description = trim($_POST['description'] ?? ''); // "Please specify" field

/* =========================================================
   VALIDATION
========================================================== */
$errors = [];

if ($username === '') {
    $errors[] = 'Username is required.';
}

$allowedDepartments = ['Executive', 'Accounting', 'Admin', 'Human Resource'];
if (!in_array($department, $allowedDepartments, true)) {
    $errors[] = 'Please select a valid department.';
}

$allowedSubjects = ['Pc/Laptop', 'Server', 'Internet / Network', 'Printer', 'Scanner', 'Others'];
if (!in_array($subject, $allowedSubjects, true)) {
    $errors[] = 'Please select a valid subject.';
}

if ($description === '') {
    $errors[] = 'Please specify the details of your issue.';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => implode(' ', $errors)
    ]);
    exit;
}

/* =========================================================
   CREATE TICKET
========================================================== */
try {
    $ticket = new Ticket($db); // $db comes from config/config.php via ticket-function.php

    $created = $ticket->createTicket(
        $username,
        $department,
        $subject,
        $description
        // priority defaults to 'Normal', status defaults to 'Open' inside createTicket()
    );

    if ($created) {
        echo json_encode([
            'success' => true,
            'message' => 'Ticket submitted successfully.'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to submit ticket. Please try again.'
        ]);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error. Please try again later.'
        // 'debug' => $e->getMessage() // uncomment temporarily while testing locally
    ]);
}