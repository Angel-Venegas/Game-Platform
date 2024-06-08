<?php
// Start Session
session_start();

// Database variables and information
$host = "localhost";
$db_username = "game-platform-user";
$db_password = "game-platform-user-password123";
$db = "WebDatabase";

// Establish a database connection
$conn = new mysqli($host, $db_username, $db_password, $db);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Response variable
$response = array();

// Retrieve submitted data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST['password'];

    // Hash the password (makes it more secured)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email or username already exists in the database
        $response['message'] = "Email or username already exists.";
        $response['status'] = "error";
    } else {
        // Insert data into database
        $query = "INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("sssss", $first_name, $last_name, $email, $username, $hashed_password);

        if ($stmt->execute()) {
            $response['message'] = "User registered successfully!";
            $response['status'] = "success";
        } else {
            $response['message'] = "Error: " . $stmt->error;
            $response['status'] = "error";
        }
    }

    $stmt->close();
}


// Close the database connection
$conn->close();

// Return the response in JSON format
echo json_encode($response);

/*
    Fontawesome:
        Fontawesome cdnjs:
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        Fontawesome icons:   
            Icons: Find the icon, click on it, and just copy the link of the icon you want
                https://fontawesome.com/icons

    
    Pixabay:
        For video loops

    
    mySQL:
        1.
            CREATE USER 'game-platform-user'@'specific-ip-address' IDENTIFIED BY 'game-platform-user-password123';
            GRANT ALL PRIVILEGES ON `WebDatabase`.* TO 'game-platform-user'@'specific-ip-address';
            FLUSH PRIVILEGES;

            CREATE USER 'game-platform-user'@'%' IDENTIFIED BY 'game-platform-user-password123';
            GRANT ALL PRIVILEGES ON `WebDatabase`.* TO 'game-platform-user'@'%';
            FLUSH PRIVILEGES;


        2.
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                username VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL
            );


        3. 
*/