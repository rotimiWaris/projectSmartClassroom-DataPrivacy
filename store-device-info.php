<?php
session_start();
// Assuming you have a database connection
// Replace these with your actual database credentials
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

// Retrieve the user's matriculation number from the database
$sql = "SELECT matricnumber, blocked FROM users WHERE id = $userID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found
    $row = $result->fetch_assoc();
    $matricNo = $row['matricnumber'];
    $blocked = $row['blocked'];

    if ($blocked == 1) {
        echo json_encode(["success" => false, "error" => "You have been blocked and cannot store your device info"]);
    } else {
        if (empty($matricNo)) {
        // Matriculation number is empty, display alert
        echo json_encode(["success" => false, "error" => "You need to Update your Matriculation Number first"]);
        
        } else {
            // Matriculation number is not empty, proceed with storing device information

            // Get JSON data from the request body
            $data = json_decode(file_get_contents("php://input"));

            // Extract user agent and platform from the data
            $userAgent = $conn->real_escape_string($data->userAgent);
            $platform = $conn->real_escape_string($data->platform);

            // Insert data into the database
            $sql = "UPDATE users SET user_agent = '$userAgent', platform = '$platform' WHERE id = $userID";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => $conn->error]);
            }
        }
    }
} else {
    // User not found
    echo json_encode(["success" => false, "error" => "User not found"]);
}

// Close the connection
$conn->close();

?>
