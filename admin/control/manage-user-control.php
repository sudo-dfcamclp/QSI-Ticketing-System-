<?php

declare(strict_types=1);

// Session check na JSON ang response (hindi redirect) kasi
// AJAX ang tumatawag dito, hindi direktang browser navigation.
//
// Gamit na natin yung centralized auth.php (parehong session
// handling gaya ng ibang page ng app) imbes na gumawa ng sarili
// nating session_name() dito — dati kasi ibang session ang
// nire-restart ng file na ito kumpara sa ginagamit ng ibang
// pages (manage-user.php view, login.php), kaya laging
// "unauthorized" kahit naka-login na yung user.
require_once __DIR__ . '/../../includes/auth/auth.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized. Please log in again.'
    ]);
    exit;
}

require_once __DIR__ . '/../../includes/functions/user-function.php';

// $users galing sa config.php/user-function.php (Users object)


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
    $raw  = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (is_array($json)) {
        return $json + $_POST + $_GET;
    }

    return $_POST + $_GET;
}


/* =============================================================
   CURRENT LOGGED-IN USER + SUPER_ADMIN CHECK
   -------------------------------------------------------------
   Kunin muna galing DATABASE (hindi lang sa $_SESSION) para
   laging up-to-date — kung na-disable/na-demote na pala ang
   admin na ito habang naka-login, hindi na dapat siya
   makapagsagawa ng action.
============================================================== */
$currentUser = $users->getById((int) $_SESSION['user_id']);

if (!$currentUser) {
    respond(['success' => false, 'message' => 'Account not found.'], 401);
}

if (($currentUser['status'] ?? 'active') === 'disable') {
    respond(['success' => false, 'message' => 'Your account has been disabled.'], 403);
}

$isSuperAdmin = ($currentUser['user_type'] ?? '') === 'super_admin';

function requireSuperAdmin(bool $isSuperAdmin): void
{
    if (!$isSuperAdmin) {
        respond([
            'success' => false,
            'message' => 'Only a super admin can do this action.'
        ], 403);
    }
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
           LIST — kunin lahat ng users (may pagination)
           GET manage-user-control.php?action=list&page=1&per_page=6
        ---------------------------------------------------- */
        case 'list': {
            $page    = max(1, (int) ($input['page'] ?? 1));
            $perPage = max(1, (int) ($input['per_page'] ?? 6));

            $allUsers = $users->getAll();

            $total      = count($allUsers);
            $totalPages = (int) max(1, ceil($total / $perPage));

            $offset    = ($page - 1) * $perPage;
            $pageItems = array_slice($allUsers, $offset, $perPage);

            respond([
                'success'         => true,
                'data'            => $pageItems,
                'total'           => $total,
                'page'            => $page,
                'per_page'        => $perPage,
                'total_pages'     => $totalPages,
                'is_super_admin'  => $isSuperAdmin,
                'current_user_id' => (int) $currentUser['user_id']
            ]);
        }

        /* ---------------------------------------------------
           CREATE — bagong user (super_admin lang)
        ---------------------------------------------------- */
        case 'create': {
            requireSuperAdmin($isSuperAdmin);

            $f_name   = trim((string) ($input['f_name'] ?? ''));
            $l_name   = trim((string) ($input['l_name'] ?? ''));
            $username = trim((string) ($input['username'] ?? ''));
            $gmail    = trim((string) ($input['gmail'] ?? ''));
            $password = (string) ($input['password'] ?? '');
            $userType = trim((string) ($input['user_type'] ?? 'admin'));

            if ($f_name === '' || $l_name === '' || $username === '' || $gmail === '' || $password === '') {
                respond(['success' => false, 'message' => 'Please complete all required fields.'], 400);
            }

            if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
                respond(['success' => false, 'message' => 'Please enter a valid email address.'], 400);
            }

            if (strlen($password) < 8) {
                respond(['success' => false, 'message' => 'Password must be at least 8 characters long.'], 400);
            }

            if (!preg_match('/^[a-zA-Z0-9._-]+$/', $username)) {
                respond(['success' => false, 'message' => 'Username may only contain letters, numbers, dots, underscores, and hyphens.'], 400);
            }

            if (!in_array($userType, ['admin', 'super_admin'], true)) {
                $userType = 'admin';
            }

            if ($users->getByUsername($username)) {
                respond(['success' => false, 'message' => 'Username is already registered.'], 409);
            }

            // "active" agad ang status kasi super_admin mismo ang
            // gumagawa/nag-a-approve ng account na ito (iba sa
            // self-registration sa register.php na "pending" pa muna).
            $created = $users->create($f_name, $l_name, $username, $gmail, $password, $userType, 'active');

            respond([
                'success' => $created,
                'message' => $created ? 'User created.' : 'Failed to create user.'
            ]);
        }

        /* ---------------------------------------------------
           UPDATE STATUS — Enable / Disable (super_admin lang)
        ---------------------------------------------------- */
        case 'update_status': {
            requireSuperAdmin($isSuperAdmin);

            $userId = (int) ($input['user_id'] ?? 0);
            $status = trim((string) ($input['status'] ?? ''));

            if ($userId <= 0 || $status === '') {
                respond(['success' => false, 'message' => 'Missing user id or status.'], 400);
            }

            if ($userId === (int) $currentUser['user_id']) {
                respond(['success' => false, 'message' => 'You cannot change the status of your own account.'], 400);
            }

            $target = $users->getById($userId);

            if (!$target) {
                respond(['success' => false, 'message' => 'User not found.'], 404);
            }

            $ok = $users->updateStatus($userId, $status);

            respond([
                'success' => $ok,
                'message' => $ok
                    ? ($status === 'disable' ? 'Account disabled.' : 'Account enabled.')
                    : 'Failed to update account status.'
            ]);
        }

        /* ---------------------------------------------------
           DELETE — tanggalin ang user (super_admin lang)
        ---------------------------------------------------- */
        case 'delete': {
            requireSuperAdmin($isSuperAdmin);

            $userId = (int) ($input['user_id'] ?? 0);

            if ($userId <= 0) {
                respond(['success' => false, 'message' => 'Invalid user id.'], 400);
            }

            if ($userId === (int) $currentUser['user_id']) {
                respond(['success' => false, 'message' => 'You cannot delete your own account.'], 400);
            }

            $target = $users->getById($userId);

            if (!$target) {
                respond(['success' => false, 'message' => 'User not found.'], 404);
            }

            $ok = $users->delete($userId);

            respond([
                'success' => $ok,
                'message' => $ok ? 'Account deleted.' : 'Failed to delete account.'
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