<?php

header('Content-Type: application/json');
$post = file_get_contents('php://input');
$posted = json_decode($post, true);
include 'account.php';

if (isset($posted['request'])) {
    if ($posted['request'] == 'get_details') {
        session_start();
        echo json_encode(array(
            'isAdmin' => $_SESSION['isAdmin'],
            'isAuthor' => $_SESSION['isAuthor'],
            'loggedIn' => $_SESSION['isLoggedIn'],
            'user' => $_SESSION['username'],
            'id' => $_SESSION['id']
        ));
    }

    if ($posted['request'] == 'get_access_details') {
        session_start();
        $account = new Account();
        echo json_encode(array('success' => true, 'hasAccess' => $account->hasFullAccess($_SESSION['username'])));
    }

    if ($posted['request'] == 'is_author') {
        if (isset($posted['username'])) {
            $account = new Account();
            if ($account->userExists($posted['username'])) {
                echo json_encode(array('success' => true, 'author' => $account->isAuthor($posted['username'])));
            } else {
                echo json_encode(array('success' => false, 'message' => 'User does not exist'));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'No username provided'));
        }
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'No request specified'));
}