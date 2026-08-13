<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../functions/user-function.php';


function response(string $status, string $message, array $data = []): void
{
    echo json_encode([
        'status'  => $status,
        'message' => $message,
        ...$data
    ]);

    exit;
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    response(
        'error',
        'Invalid request method.'
    );
}



$input = file_get_contents('php://input');

$data = json_decode($input, true);



if (!is_array($data)) {

    response(
        'error',
        'Invalid request data.'
    );
}



$f_name = trim($data['f_name'] ?? '');
$l_name = trim($data['l_name'] ?? '');
$username = trim($data['username'] ?? '');
$gmail = trim($data['gmail'] ?? '');
$password = $data['password'] ?? '';
$confirmPassword = $data['confirm_password'] ?? '';



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



if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {

    response(
        'error',
        'Please enter a valid email address.'
    );
}



if ($password !== $confirmPassword) {

    response(
        'error',
        'The passwords do not match.'
    );
}



if (strlen($password) < 8) {

    response(
        'error',
        'Password must be at least 8 characters long.'
    );
}



if (!preg_match('/^[a-zA-Z0-9._-]+$/', $username)) {

    response(
        'error',
        'Username may only contain letters, numbers, dots, underscores, and hyphens.'
    );
}



try {


    $existingUser = $users->getByUsername($username);

    if ($existingUser) {

        response(
            'error',
            'Username is already registered.'
        );
    }


    $created = $users->create(
        $f_name,
        $l_name,
        $username,
        $gmail,
        $password
    );


    if (!$created) {

        response(
            'error',
            'Unable to create the account.'
        );
    }


    response(
        'success',
        'Account created successfully.'
    );


} catch (Throwable $e) {


    error_log(
        'Registration error: ' . $e->getMessage()
    );


    if ($e instanceof PDOException && $e->getCode() === '23000') {

        response(
            'error',
            'Username or email address is already registered.'
        );
    }


    response(
        'error',
        'An unexpected server error occurred. Please try again.'
    );
}