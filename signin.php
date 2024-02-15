<?php
//include auth_session.php file on all user panel pages
session_start();

if (isset($_SESSION["users_id"])) {
    
    $mysqli = require __DIR__ . "/db.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["users_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();

    if (isset($user)) {
        header ("Location: dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Privacy And Security in Smart Classroom - SignIn</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <link rel="icon" href="images/favicon.ico">
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Table Style -->
    <style>
        table {
            border-collapse: separate;
            border-spacing: 0 15px;
        }
    </style>
</head>

<body>
    <?php

    $is_invalid = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $host = "localhost";
        $dbname = "LoginSystem";
        $username = "root";
        $password = "";

        $mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
        
        $sql = sprintf("SELECT * FROM users
                        WHERE email = '%s'",
                    $mysqli->real_escape_string($_POST["email"]));
        
        $result = $mysqli->query($sql);
        
        $user = $result->fetch_assoc();
        
        if ($user) {
            
            if (password_verify($_POST["password"], $user["password_hash"])) {
                
                session_start();
                
                session_regenerate_id();
                
                $_SESSION["users_id"] = $user["id"];
                
                header("Location: dashboard.php");
                exit;
            }
        }
        
        $is_invalid = true;
    }

?>
    <!-- Sing in  Form -->
    <?php 
        include('header.php');
    ?>
    <section class="sign-in">
        <div class="container-style">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                    <a href="signup.php" class="signup-image-link">Back to sign up page</a>
                    <a href="adminsignin.php" class="signup-image-link">Admin login</a>
                    <p style="font-size:10px;text-align:center;">Please feel free to contact our team, if you face any issues while logging in.</p>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">Data Privacy And Security in Smart Classroom</h2>
                    <h3 class="form-title">Sign in</h3>
                    <?php if ($is_invalid): ?>
                        <p style="text-align: center; color: red">Invalid login</p>
                    <?php endif; ?>
                    <form method="POST" class="register-form" action="signin.php">
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" name="email" id="email" placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="Password" />
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- JS -->
    <!-- <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script> -->
</body>

</html>