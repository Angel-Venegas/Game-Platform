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
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT password FROM users WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            echo json_encode(["status" => "success", "message" => "Login successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Incorrect password"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Username does not exist"]);
    }
    $stmt->close();
}

$connection->close();