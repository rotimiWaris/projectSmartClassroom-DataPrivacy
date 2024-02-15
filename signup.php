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
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Data Privacy And Security in Smart Classroom - SignUp</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Icon -->
 <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
<!-- Main css -->
<link rel="stylesheet" href="css/style.css">

<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
<script src="js/validation.js" defer></script>

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
        include('header.php');
        // require('db.php');
        // // When form submitted, insert values into the database.
        // if (isset($_REQUEST['name'])) {
        //     // removes backslashes
        //     $username = stripslashes($_REQUEST['name']);
        //     //escapes special characters in a string
        //     $username = mysqli_real_escape_string($con, $username);
        //     $email    = mysqli_real_escape_string($con, $username);
        //     $email    = mysqli_real_escape_string($con, $email);
        //     $password = stripslashes($_REQUEST['pass']);
        //     $password = mysqli_real_escape_string($con, $password);
        //     $create_datetime = date("Y-m-d H:i:s");
        //     $query    = "INSERT into `users` (username, password, email, create_datetime)
        //                  VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime')";
        //     $result   = mysqli_query($con, $query);
        //     if ($result) {
        //         echo "<div class='form'>
        //               <h3>You are registered successfully.</h3><br/>
        //               <p class='link'>Click here to <a href='signin.php'>Login</a></p>
        //               </div>";
        //     } else {
        //         echo "<div class='form'>
        //               <h3>Required fields are missing.</h3><br/>
        //               <p class='link'>Click here to <a href='index.php'>registration</a> again.</p>
        //               </div>";
        //     }
        // } else {
    ?>
    <!-- Sign up form -->
    <section class="signup">
        <div class="container-style">
            <div class="signup-content">
                <div class="signup-form">
                    <h3 class="form-title">Data Privacy And Security in Smart Classroom</h3>
                    <h4 class="form-title">Sign up</h4>
                    <form method="POST" action="registration.php" class="register-form" id="register-form" novalidate>
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account"></i></label>
                            <input type="text" name="name" id="name" placeholder="Your Username" />
                        </div>
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" name="email" id="email" placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="pass" id="pass" placeholder="Password" />
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                    <a href="signin.php" class="signup-image-link">I am already member</a>
                    <a href="adminsignin.php" class="signup-image-link">Admin login</a>
                    <p style="font-size:10px;text-align:center;">Please feel free to contact our team, if you face any issues while logging in.</p>
                </div>
            </div>
        </div>
        
    </section>
    <!-- JS -->
    <!-- <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"
        integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous">
    </script>
    <script src="js/main.js"></script> -->
    <?php
    // }
?>
</body>

</html>