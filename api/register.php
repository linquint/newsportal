<?php

include 'account.php';

header('Content-Type: application/json');
$post = file_get_contents('php://input');
$posted = json_decode($post, true);

if (isset($posted)) {
    if (isset($posted['username']) && isset($posted['password']) && isset($posted['passwordConfirm']) && isset($posted['email'])) {
        $account = new Account();
        $username = trim($posted['username']);
        $password = trim($posted['password']);
        $passwordConfirm = trim($posted['passwordConfirm']);
        $email = $posted['email'];

        if ($password != $passwordConfirm) {
            echo json_encode(array('success' => false, 'message' => 'Passwords do not match.'));
            exit;
        }

        if (strlen($password) < 8 || strlen($passwordConfirm) < 8 || strlen($username) < 4) {
            echo json_encode(array('success' => false, 'message' => 'Username or password is too short.'));
            exit;
        }
        $res = $account->isAvailable($username, $email);

        if ($res) {
            $account->register($username, password_hash($password, PASSWORD_ARGON2ID), $email);
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Username or email already exists'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Missing parameters'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request'));
}
