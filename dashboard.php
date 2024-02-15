<?php
//include auth_session.php file on all user panel pages
session_start();
if (isset($_SESSION["users_id"])) {
    
    $mysqli = require __DIR__ . "/db.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["users_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}
else {
    header ("Location: signin.php");
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
                
$userID = $_SESSION['users_id'];
$sql = "SELECT user_agent, blocked FROM users WHERE id = $userID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $blocked = $row['blocked'];
    // Check if user_agent is not empty and not null
    if (!empty($row['user_agent']) && $row['user_agent'] !== null && $blocked != 1) {
        // user_agent is not empty, display the "Remove Device" button
        $space = '<br><br>';
        $buttonHTML = '<button id="removeDeviceBtn" class="btn btn-danger">Remove Device</button>';
    } else {
        // user_agent is empty, do not display the "Remove Device" button
        $space = '';
        $buttonHTML = '';
    }
} else {
    // No user found, do not display the "Remove Device" button
    $space = '';
    $buttonHTML = '';
}


?>

<!DOCTYPE html>
<html>
    <!-- Font Icon -->
<link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
<link rel="stylesheet" href="css/style.css">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Data Privacy And Security in Smart Classroom | Student Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <link rel="icon" href="images/favicon.ico">

        <style>
        .user-info {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            max-width: 400px;
        }

        .user-info h2 {
            color: #333;
        }

        .user-info p {
            margin: 5px 0;
            color: #666;
        }
    </style>
    </head>
    <body>
    <?php
        include('header.php');
    ?>
    <div class="form">
        <div class="container-style">
        <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Hey, Welcome <?= htmlspecialchars($user["username"]) ?>!</h2>

                    <h3>Welcome to your dashboard.</h3>
                    <!-- <p>You will receive the daily notification of next day classes on <?php echo $_SESSION['your_name']; ?></p>
                    <p>Use below buttons to navigate.</p> -->
                    <br>
                    <?php if (!empty($user['matricnumber'])) : ?>
                    <div class="user-info">
                        <h2>User Profile</h2>
                        <p><strong>Name:</strong> <?php echo $user['firstname'] . ' ' . $user['lastname']; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                        <p><strong>Matriculation Number:</strong> <?php echo $user['matricnumber']; ?></p>
                        <p><strong>Gender:</strong> <?php echo $user['gender']; ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo $user['dob']; ?></p>
                        <p><strong>Faculty:</strong> <?php echo $user['faculty']; ?></p>
                        <p><strong>Department:</strong> <?php echo $user['department']; ?></p>
                    </div>
                    <?php endif; ?>
                    <button class="btn btn-info" id="getDeviceInfoBtn">Store Device Info</button>
                    <?php if ($user['blocked'] !== 1) : ?>
                    <?php echo $space; ?>                    
                    <?php echo $buttonHTML; ?>                    
                    <?php endif; ?>
                    <br><br>
                    <a type="button" class="btn btn-primary" href="updateprofile.php">Update Your Profile</a>
                  <!--  <a type="button" class="btn btn-primary" href="changepassword.php">Change Password</a> -->
                </div>
                <div class="signup-image">
                    <figure><img src="images/student.png" alt="admin image"></figure>
                    <a href="logout.php" class="signup-image-link">Logout</a>
                </div>
            </div>
        </div>
    <!-- JS -->
    <!-- <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"
        integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous">
    </script>
    <script src="js/main.js"></script> -->
    <!--footer-->

    <script>
        document.getElementById('getDeviceInfoBtn').addEventListener('click', getDeviceInfo);

        function getDeviceInfo() {
        // Check if the necessary properties are available
        if ('userAgent' in navigator && 'platform' in navigator) {
            // Retrieve device information
            const data = {
                userAgent: navigator.userAgent,
                platform: navigator.platform
            };

            console.log(data);

            fetch('store-device-info.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                // Device information stored successfully
                alert('Device stored successfully.');

                location.reload(true);
            } else {
                // Error storing device information
                alert(data.error);
            }
            })
            .catch(error => {
              console.error('Error:', error);
            });

        }
        }

        document.addEventListener('DOMContentLoaded', function() {
        var removeDeviceBtn = document.getElementById('removeDeviceBtn');

        if (removeDeviceBtn) {
            removeDeviceBtn.addEventListener('click', function() {
                // Confirm the removal (you can customize this confirmation)
                var confirmRemoval = confirm('Are you sure you want to remove the device information?');

                if (confirmRemoval) {
                    // Perform the removal using AJAX
                    fetch('delete-device-info.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Device information removed successfully
                            alert('Device information removed successfully.');

                            location.reload(true);
                        } else {
                            // Error removing device information
                            alert('Error: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        }
    });
</script>
    </body>
</html>