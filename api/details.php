<?php

session_start();
echo json_encode(array(
    'isAdmin' => $_SESSION['isAdmin'],
    'isAuthor' => $_SESSION['isAuthor'],
    'loggedIn' => $_SESSION['isLoggedIn'],
    'user' => $_SESSION['username'],
));