<?php

include 'account.php';

header('Content-Type: application/json');
$post = file_get_contents('php://input');
$posted = json_decode($post, true);

if (isset($posted)) {
    $username = $posted['username'];
    $password = $posted['password'];

    if (isset($posted['username'] ) && isset($posted['password'])) {
        $account = new Account();
        $loginData = $account->login($username, md5($password));

        if ($loginData != null) {
            $isAdmin = $account->isAdmin($loginData['id']);
            $isAuthor = $account->isAuthor($loginData['id']);
            session_start();
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['username'] = $loginData['username'];
            $_SESSION['isAdmin'] = $isAdmin;
            $_SESSION['isAuthor'] = $isAuthor;
            echo json_encode(array('success' => true, 'isAdmin' => $isAdmin, 'isAuthor' => $isAuthor, 'username' => $loginData['username']));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Incorrect username or password'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Missing login data'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Incorrect request'));
}