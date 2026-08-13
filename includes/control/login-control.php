
<?php

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../functions/user-function.php';


/*
|--------------------------------------------------------------------------
| JSON Response Helper
|--------------------------------------------------------------------------
*/

function response(string $status, string $message, array $data = []): void
{
    echo json_encode([
        'status'  => $status,
        'message' => $message,
        ...$data
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Request Method
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    response(
        'error',
        'Invalid request method.'
    );
}


/*
|--------------------------------------------------------------------------
| Read JSON Request
|--------------------------------------------------------------------------
*/

$input = file_get_contents('php://input');

$data = json_decode($input, true);

if (!is_array($data)) {
    response(
        'error',
        'Invalid request data.'
    );
}


/*
|--------------------------------------------------------------------------
| Get Credentials
|--------------------------------------------------------------------------
*/

$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';


/*
|--------------------------------------------------------------------------
| Validate Credentials
|--------------------------------------------------------------------------
*/

if ($username === '' || $password === '') {
    response(
        'error',
        'Please enter your username and password.'
    );
}


/*
|--------------------------------------------------------------------------
| Authenticate User
|--------------------------------------------------------------------------
*/

try {

    $user = $users->getByUsername($username);

    if (!$user) {
        response(
            'error',
            'Invalid username or password.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Verify Password
    |--------------------------------------------------------------------------
    */

    if (!password_verify($password, $user['password'])) {
        response(
            'error',
            'Invalid username or password.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Regenerate Session
    |--------------------------------------------------------------------------
    */

    session_regenerate_id(true);


    /*
    |--------------------------------------------------------------------------
    | Store User Information
    |--------------------------------------------------------------------------
    */

    $_SESSION['user_id']  = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['f_name']   = $user['f_name'];
    $_SESSION['l_name']   = $user['l_name'];
    $_SESSION['gmail']    = $user['gmail'];


    /*
    |--------------------------------------------------------------------------
    | Successful Login
    |--------------------------------------------------------------------------
    */

    response(
        'success',
        'Welcome back, ' . $user['f_name'] . '!',
        [
            'redirect' => 'dashboard.php'
        ]
    );


} catch (Throwable $e) {

    error_log(
        'Login error: ' . $e->getMessage()
    );

    response(
        'error',
        'An unexpected server error occurred. Please try again.'
    );
}

