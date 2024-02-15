<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["f-name"];
    $lastname = $_POST["l-name"];
    $matricnumber = $_POST["matricno"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $faculty = $_POST["fact"];
    $department = $_POST["dept"];
    
    $host = "localhost";
        $dbname = "LoginSystem";
        $username = "root";
        $password = "";

        $mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
        
        if ($mysqli->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', matricnumber='$matricnumber',
                gender='$gender', dob='$dob', faculty='$faculty', department='$department'";

        if ($mysqli->query($sql) === TRUE) {
            header("Location: signin.php");
            exit;
        } else {
            echo "Error updating user information: " . $conn->error;
        }

        // Close the database connection
        $mysqli->close();
}

?>