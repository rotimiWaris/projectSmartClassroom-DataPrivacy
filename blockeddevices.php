<?php

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

// Function to unblock a device
function unblockDevice($deviceId) {
    global $conn;
    $unblockQuery = "UPDATE users SET blocked = NULL WHERE id = ?";
    $stmtUnblock = $conn->prepare($unblockQuery);
    $stmtUnblock->bind_param("i", $deviceId);
    $stmtUnblock->execute();
    $stmtUnblock->close();

    header ("Location: blockeddevices.php");
}

// Check if the form is submitted to unblock a device
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unblock_device'])) {
    $deviceIdToUnblock = $_POST['device_id_to_unblock'];
    unblockDevice($deviceIdToUnblock);
}

// Fetch information about blocked devices
$sql = "SELECT id, matricnumber, user_agent, platform FROM users WHERE blocked = 1";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php 
        include('header.php');
    ?>
    
    <h2>Blocked Devices</h2>

    <?php
    if ($result !== false && $result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Matric Number</th><th>Device Info</th><th>Platform</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['matricnumber'] . "</td>";
            echo "<td>" . $row['user_agent'] . "</td>";
            echo "<td>" . $row['platform'] . "</td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='device_id_to_unblock' value='" . $row['id'] . "'>";
            echo "<button type='submit' class='btn btn-info' name='unblock_device'>Unblock</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No blocked devices found.</p>";
    }
    ?>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
