<?php

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
| Only Allow POST Requests
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


/*
|--------------------------------------------------------------------------
| Validate JSON
|--------------------------------------------------------------------------
*/

if (!is_array($data)) {

    response(
        'error',
        'Invalid request data.'
    );
}


/*
|--------------------------------------------------------------------------
| Get Form Data
|--------------------------------------------------------------------------
*/

$f_name = trim($data['f_name'] ?? '');
$l_name = trim($data['l_name'] ?? '');
$username = trim($data['username'] ?? '');
$gmail = trim($data['gmail'] ?? '');
$password = $data['password'] ?? '';
$confirmPassword = $data['confirm_password'] ?? '';


/*
|--------------------------------------------------------------------------
| Required Fields
|--------------------------------------------------------------------------
*/

if (
    $f_name === '' ||
    $l_name === '' ||
    $username === '' ||
    $gmail === '' ||
    $password === '' ||
    $confirmPassword === ''
) {

    response(
        'error',
        'Please complete all required fields.'
    );
}


/*
|--------------------------------------------------------------------------
| Validate Email
|--------------------------------------------------------------------------
*/

if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {

    response(
        'error',
        'Please enter a valid email address.'
    );
}


/*
|--------------------------------------------------------------------------
| Confirm Password
|--------------------------------------------------------------------------
*/

if ($password !== $confirmPassword) {

    response(
        'error',
        'The passwords do not match.'
    );
}


/*
|--------------------------------------------------------------------------
| Password Length
|--------------------------------------------------------------------------
*/

if (strlen($password) < 8) {

    response(
        'error',
        'Password must be at least 8 characters long.'
    );
}


/*
|--------------------------------------------------------------------------
| Username Validation
|--------------------------------------------------------------------------
*/

if (!preg_match('/^[a-zA-Z0-9._-]+$/', $username)) {

    response(
        'error',
        'Username may only contain letters, numbers, dots, underscores, and hyphens.'
    );
}


/*
|--------------------------------------------------------------------------
| Create Account
|--------------------------------------------------------------------------
*/

try {

    /*
    |--------------------------------------------------------------------------
    | Check Username
    |--------------------------------------------------------------------------
    */

    $existingUser = $users->getByUsername($username);

    if ($existingUser) {

        response(
            'error',
            'Username is already registered.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create User
    |--------------------------------------------------------------------------
    |
    | user-function.php handles password_hash()
    |
    */

    $created = $users->create(
        $f_name,
        $l_name,
        $username,
        $gmail,
        $password
    );


    /*
    |--------------------------------------------------------------------------
    | Registration Result
    |--------------------------------------------------------------------------
    */

    if (!$created) {

        response(
            'error',
            'Unable to create the account.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Success
    |--------------------------------------------------------------------------
    */

    response(
        'success',
        'Account created successfully.'
    );


} catch (Throwable $e) {

    /*
    |--------------------------------------------------------------------------
    | Log Server Error
    |--------------------------------------------------------------------------
    */

    error_log(
        'Registration error: ' . $e->getMessage()
    );


    /*
    |--------------------------------------------------------------------------
    | Handle Duplicate Database Entry
    |--------------------------------------------------------------------------
    */

    if ($e instanceof PDOException && $e->getCode() === '23000') {

        response(
            'error',
            'Username or email address is already registered.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | General Error
    |--------------------------------------------------------------------------
    */

    response(
        'error',
        'An unexpected server error occurred. Please try again.'
    );
}