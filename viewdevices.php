<?php
//include auth_session.php file on all user panel pages
session_start();

if (isset($_SESSION["admins_id"])) {
    
    $mysqli = require __DIR__ . "/db.php";
    
    $sql = "SELECT * FROM admins
            WHERE id = {$_SESSION["admins_id"]}";
            
    $result = $mysqli->query($sql);
    
    $admin = $result->fetch_assoc();
}
else {
    header ("Location: adminsignin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Devices</title>
    <style>
        /* body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        } */
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<?php 
    include('header.php');
?>
<h1>Admin Devices</h1>

<?php
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



// Fetch devices information including user_agent from the users table
$sql = "SELECT id, matricnumber, user_agent, platform, blocked FROM users WHERE user_agent IS NOT NULL AND user_agent != '' AND blocked !=1";
$result = $conn->query($sql);

echo "<form method='post'>";
echo "<table>";
echo "<tr><th>Matric Number</th><th>Student Device</th><th>Platform</th><th>Actions</th></tr>";

if ($result !== false && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        if (!empty($row['user_agent']) && $row['user_agent'] !== null) {
            echo "<tr>";
            echo "<td>" . $row['matricnumber'] . "</td>";
            echo "<td>" . $row['user_agent'] . "</td>";
            echo "<td>" . $row['platform'] . "</td>";
            echo "<td>";
            echo "<button type='submit' name='remove_device' class='btn btn-secondary' value='" . $row['id'] . "'>Remove</button> <br><br>";
            echo "<button type='submit' name='block_user' class='btn btn-danger' value='" . $row['id'] . "'>Block</button>";
            echo "</td>";
            echo "</tr>";
        } 
    } 
        
} else {
    // user_agent is empty or null, provide a message or handle accordingly
    echo "<tr><td colspan='5'>No devices found.</td></tr>";
}

echo "</table>";
echo "</form>";


if (isset($_POST['remove_device'])) {
    $deviceId = $_POST['remove_device'];

    // Use prepared statement to prevent SQL injection
    $sqlDelete = "UPDATE users SET user_agent = NULL, platform = NULL WHERE id = ?";
    $stmt = $conn->prepare($sqlDelete);

    // Bind the parameter
    $stmt->bind_param("i", $deviceId);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Device removed successfully!')</script>";
        echo '<script>window.location.href = "viewdevices.php";</script>';
    } else {
        echo "Error removing device: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Check if Block button is clicked
if (isset($_POST['block_user'])) {
    $userId = $_POST['block_user'];

    // Use prepared statement to prevent SQL injection
    $sql = "UPDATE users SET blocked = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Bind the parameter
    $stmt->bind_param("i", $userId);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('User blocked successfully!')</script>";
        echo '<script>window.location.href = "viewdevices.php";</script>';
    } else {
        echo "Error blocking user: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}


// Close the connection
$conn->close();
?>

</body>
</html>
