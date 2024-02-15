<?php
//include auth_session.php file on all user panel pages
session_start();
if (isset($_SESSION["admins_id"])) {
    
    $mysqli2 = require __DIR__ . "/db.php";
    
    $sql2 = "SELECT * FROM admins
            WHERE id = {$_SESSION["admins_id"]}";
            
    $result2 = $mysqli2->query($sql2);
    
    $admin = $result2->fetch_assoc();

    if (isset($admin)) {
        header ("Location: admindashboard.php");
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Data Privacy And Security in Smart Classroom - Admin SignIn</title>
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
    $mysqli = require __DIR__ . "/db.php";

    $is_invalid = false;

    if(isset($_POST['signin']))//this will tell us what to do if some data has been post through form with button.
{
    $admin_name=$_POST['your_name'];
    $admin_pass=$_POST['your_pass'];

    $admin_query="select * from admins where username='$admin_name' AND password='$admin_pass'";

    $run_query=mysqli_query($mysqli,$admin_query);

    $admin = $run_query->fetch_assoc();

    if(mysqli_num_rows($run_query)>0)
    {
        session_start();
            
        session_regenerate_id();
        
        $_SESSION["admins_id"] = $admin["id"];

        header("Location: admindashboard.php");
        exit;
    }
    $is_invalid = true;

}
?>
<?php
    include('header.php');
?>
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container-style">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="index.php" class="signup-image-link">Not an admin? back to user page</a>
                    </div>

                    <div class="signin-form">
                        <h3 class="form-title">Data Privacy And Security in Smart Classroom</h3>
                        <h5 class="form-title">Welcome Admin, Sign in here</h5>
                        <?php if ($is_invalid): ?>
                            <p style="text-align: center; color: red">Invalid login</p>
                        <?php endif; ?>
                        <form method="POST" class="register-form" id="login-form" action="adminsignin.php">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="your_name" id="your_name" placeholder="Your Username"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="your_pass" id="your_pass" placeholder="Password"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
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