<?php

include 'account.php';

header('Content-Type: application/json');
$post = file_get_contents('php://input');
$posted = json_decode($post, true);

if (isset($posted)) {
    if (isset($posted['username']) && isset($posted['password'])) {
        $account = new Account();
        $username = $posted['username'];
        $password = $posted['password'];
        $loginData = $account->login($username, $password);

        if ($loginData != null) {
            $isAdmin = $account->isAdmin($loginData['id']);
            $isAuthor = $account->isAuthor($loginData['username']);
            session_start();
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['username'] = $loginData['username'];
            $_SESSION['isAdmin'] = $isAdmin;
            $_SESSION['isAuthor'] = $isAuthor;
            $_SESSION['id'] = $loginData['id'];
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