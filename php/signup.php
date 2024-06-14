<?php
// Start Session
session_start();

// Database variables and information
$host = "web-database-connection.c2bgjskgzi5h.us-east-2.rds.amazonaws.com";
$db_username = "game-platform-user";
$db_password = "game-platform-user-password123";
$db = "WebDatabase";

// Establish a database connection
$connection = new mysqli($host, $db_username, $db_password, $db);

// Check if the connection was successful
if ($connection->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $connection->connect_error]));
}

// Retrieve submitted data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password != $confirm_password) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match"]);
        exit();
    }

    // Hash the password (makes it more secured)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email or username already exists in the database
    $query = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email or username already exists in the database
        echo json_encode(["status" => "error", "message" => "Email or username already exists"]);
        exit();
    } else {
        // Insert data into database
        $query = "INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $username, $hashed_password);

        if ($stmt->execute()) {
            // Registration successful
            echo json_encode(["status" => "success", "message" => "User registered successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }
        exit();
    }

    $stmt->close();
}

// Close the database connection
$connection->close();
?>