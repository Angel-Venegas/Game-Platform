<?php
session_start();

$host = "web-database-connection.c2bgjskgzi5h.us-east-2.rds.amazonaws.com";
$db_username = "game-platform-user";
$db_password = "game-platform-user-password123";
$db = "WebDatabase";

$connection = new mysqli($host, $db_username, $db_password, $db);

if ($connection->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $connection->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match"]);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email or username already exists"]);
        exit();
    } else {
        $query = "INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $username, $hashed_password);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "User registered successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }
        exit();
    }
}

$connection->close();