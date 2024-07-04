<?php
session_start();

$response = array(
    'isLoggedIn' => isset($_SESSION['username']),
    'username' => isset($_SESSION['username']) ? $_SESSION['username'] : ''
);

echo json_encode($response);