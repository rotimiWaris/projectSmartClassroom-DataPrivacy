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

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have sanitized and validated the input, if not, do so to prevent SQL injection

    $id = $_POST['id'];
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $matricnumber = $_POST['matricno'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $faculty = $_POST['fact'];
    $department = $_POST['dept'];

    // Update user info in the database
    $query = "UPDATE users 
              SET firstname=?, lastname=?, matricnumber=?, gender=?, dob=?, faculty=?, department=? 
              WHERE id=?";
    if ($stmt = $mysqli->prepare($query)) {
        // Bind parameters
        $stmt->bind_param("sssssssi", $firstname, $lastname, $matricnumber, $gender, $dob, $faculty, $department, $id);

        // Execute the statement
        if ($stmt->execute()) {
            $message = "<p style='color:green;'> Details updated successfully! </p>";
        } else {
            $message = "<p style='color:green;'> Details updated successfully! </p>" . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $message = "<p style='color:green;'> Details updated successfully! </p>" . $mysqli->error;
    }
}

// if (count($_POST)>0) {
//     mysqli_query($mysqli, "UPDATE users set firstname='" . $_POST['fname'] . "', lastname='" . 
//                 $_POST['lname'] . "',  matricnumber='" . $_POST['matricno'] . "',  gender='" . $_POST['gender'] . "',
//                 dob='" . $_POST['dob'] . "', faculty='" . $_POST['fact'] . "', department='" . $_POST['dept'] . "'
//                 WHERE id='" . $_POST['id'] . "'");
//     $message = "<p style='color:green;'> Details updated successfully! </p>";
// }

?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Data Privacy And Security in Smart Classroom - Update Profile</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Icon -->
 <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
<!-- Main css -->
<link rel="stylesheet" href="css/style.css">

<!-- Table Style -->
<style>
    table {
        border-collapse: separate;
        border-spacing: 0 15px;
    }

    label[for="sex"] {
            font-size: 18px;
            margin-right: 10px;
        }
    
    
    #dob {
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
    }

    #dob:focus {
        border-color: #007bff;
    }

    #gender {
        margin-left: 30px;
        padding: 8px; /* Adjust padding to match the input field */
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        -webkit-appearance: none; /* Remove default arrow on Safari and Chrome */
        -moz-appearance: none; /* Remove default arrow on Firefox */
        appearance: none; /* Remove default arrow on modern browsers */
        background: url('https://cdn.iconscout.com/icon/free/png-256/arrow-down-1767484-1490113.png') no-repeat; /* Add custom arrow */
        background-position: right center;
        background-size: 20px; /* Adjust arrow size */
    }

    #gender:focus {
        border-color: #007bff;
    }
</style>
</head>

<body>
    <?php
        include('header.php');    
    ?>
    <section class="signup">
        <div class="container-style">
            <div class="signup-content">
                <div class="signup-form">
                    <h3 class="form-title">Data Privacy And Security in Smart Classroom</h3>
                    <h4 class="form-title">Update Your Profile</h4>
                    <form method="POST" action="updateprofile.php" class="register-form" id="register-form">
                        <?php 
                            $result = $mysqli->query($sql);

                            if ($result) {
                                if (mysqli_num_rows($result)>0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        // print_r($row['username']);
                                        ?>
                                            <h6 class="form-title"><?php if(isset($message)) { echo $message; } ?> </h6>
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                                        <div class="form-group">
                                            <label for="fname"><i class="zmdi zmdi-account-circle"></i></label>
                                            <input type="text" name="fname" id="fname" value="<?php echo $row['username']; ?>" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="lname"><i class="zmdi zmdi-account-circle"></i></label>
                                            <input type="text" name="lname" id="lname" placeholder="Last Name" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="matricno"><i class="zmdi zmdi-n-1-square"></i></label>
                                            <input type="text" name="matricno" id="name" placeholder="Matric Number" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender"><i class="zmdi zmdi-male-female"></i></label>
                                            <select id="gender" name="gender" required>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <h6><i class="zmdi zmdi-time"></i> Date of Birth:</h6>
                                        <div class="form-group">
                                            <label for="dob"></label>
                                            <input type="date" name="dob" id="dob" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="fact"><i class="zmdi zmdi-store"></i></label>
                                            <input type="text" name="fact" id="fact" placeholder="Faculty" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="dept"><i class="zmdi zmdi-accounts"></i></label>
                                            <input type="text" name="dept" id="dept" placeholder="Department" required/>
                                        </div>
                                        <div class="form-group form-button">
                                            <input type="submit" name="updateprofile" class="form-submit" value="Update" />
                                        </div>

                                        <?php
                                    }
                                }
                            }
                            $mysqli->close();

                        ?>
                        
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
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
</body>

</html>