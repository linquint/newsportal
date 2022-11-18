<?php

include 'account.php';

header('Content-Type: application/json');
$post = file_get_contents('php://input');
$posted = json_decode($post, true);

if (isset($posted)) {
    $username = $posted['username'];
    $password = $posted['password'];
    $email = $posted['email'];

    if (isset($posted['username']) && isset($posted['password']) && isset($posted['email'])) {
        $account = new Account();
        $res = $account->isAvailable($username, $email);

        if ($res) {
            $response = $account->register($username, md5($password), $email);
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
