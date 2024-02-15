<?php

session_start();

$host = "localhost";
$dbname = "LoginSystem";
$username = "root";
$password = "";

// Create a connection
$conn = new mysqli(hostname: $host,
                    username: $username,
                    password: $password,
                    database: $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume you have a session variable storing the current user's ID
// Replace 'user_id' with your actual session variable
$userID = $_SESSION['users_id'];

// Delete device information for the current user
$sqlCheck = "SELECT user_agent FROM users WHERE id = $userID";
$resultCheck = $conn->query($sqlCheck);

if ($resultCheck->num_rows > 0) {
    $rowCheck = $resultCheck->fetch_assoc();

    // Check if user_agent is not empty and not null
    if (!empty($rowCheck['user_agent']) && $rowCheck['user_agent'] !== null) {
        // Delete the user_agent for the current user
        $sqlDelete = "UPDATE users SET user_agent = NULL, platform = NULL WHERE id = $userID";

        if ($conn->query($sqlDelete) === TRUE) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
    } else {
        // user_agent is empty or null, provide a message or handle accordingly
        echo json_encode(["success" => false, "error" => "user_agent is empty or null"]);
    }
} else {
    // No user found, provide a message or handle accordingly
    echo json_encode(["success" => false, "error" => "User not found"]);
}


// Close the connection
$conn->close();

?>
