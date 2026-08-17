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

/* =============================================================
   ATTACHMENT UPLOAD (optional)
   -------------------------------------------------------------
   - Physical file -> C:\xampp\htdocs\ticketing\attachment
   - Sa "attachment" column sa DB, RELATIVE path lang ang
     isi-save (hal. "attachment/resibo_20260817_..._a1b2c3d4.pdf"),
     HINDI yung buong Windows path — mas portable ito kung
     lumipat man ng drive/server, at yun din ang expected format
     kung ipapakita mo balang araw bilang <a href> link.
============================================================== */
define('ATTACHMENT_DIR', 'C:\\xampp\\htdocs\\ticketing\\attachment');

$allowedExt = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg'];
$maxSize    = 10 * 1024 * 1024; // 10MB

$attachmentRelativePath = null;

if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE) {

    $file = $_FILES['attachment'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Failed to upload attachment.';
    } else {
        $originalName = $file['name'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt, true)) {
            $errors[] = 'Unsupported attachment type.';
        } elseif ($file['size'] > $maxSize) {
            $errors[] = 'Attachment exceeds the 10MB limit.';
        } elseif (!is_uploaded_file($file['tmp_name'])) {
            // Extra safety — tinitiyak na galing talaga ito sa
            // isang totoong HTTP upload, hindi manu-manong
            // pinasok na $_FILES value.
            $errors[] = 'Invalid file upload.';
        } else {
            // Ligtas/unique na filename — iwas overwrite kapag
            // magkapareho ang orihinal na filename ng dalawang user,
            // at iwas path traversal galing sa filename mismo.
            $safeBase   = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $uniqueName = $safeBase . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

            if (!is_dir(ATTACHMENT_DIR)) {
                mkdir(ATTACHMENT_DIR, 0775, true);
            }

            $destination = rtrim(ATTACHMENT_DIR, '\\/') . DIRECTORY_SEPARATOR . $uniqueName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $attachmentRelativePath = 'attachment/' . $uniqueName;
            } else {
                $errors[] = 'Failed to save attachment. Check folder permissions.';
            }
        }
    }
}

if (!empty($errors)) {
    // Kung na-validate na ang ibang fields pero na-fail sa attachment
    // check pagkatapos ma-move na yung file (edge case), i-clean up
    // para walang naiiwang orphan file sa disk.
    if ($attachmentRelativePath) {
        @unlink(rtrim(ATTACHMENT_DIR, '\\/') . DIRECTORY_SEPARATOR . basename($attachmentRelativePath));
    }

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
        $description,
        'Low',                    // default priority (dapat tugma sa enum: Low/Medium/Critical)
        'Pending',                // default status
        $attachmentRelativePath   // null kung walang attachment
    );

    if ($created) {
        echo json_encode([
            'success' => true,
            'message' => 'Ticket submitted successfully.'
        ]);
    } else {
        // Kung nag-fail ang DB insert matapos naman ma-move na yung
        // file, i-clean up para walang naiiwang orphan file.
        if ($attachmentRelativePath) {
            @unlink(rtrim(ATTACHMENT_DIR, '\\/') . DIRECTORY_SEPARATOR . basename($attachmentRelativePath));
        }

        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to submit ticket. Please try again.'
        ]);
    }
} catch (Throwable $e) {
    if ($attachmentRelativePath) {
        @unlink(rtrim(ATTACHMENT_DIR, '\\/') . DIRECTORY_SEPARATOR . basename($attachmentRelativePath));
    }

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error. Please try again later.'
        // 'debug' => $e->getMessage() // uncomment temporarily while testing locally
    ]);
}