<?php

        // When form submitted, insert values into the database.
        if (empty($_POST["name"])) {
            die("Name is required");
        }
        
        if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("Valid email is required");
        }
        
        if (strlen($_POST["pass"]) < 8) {
            die("Password must be at least 8 characters");
        }
        
        if ( ! preg_match("/[a-z]/i", $_POST["pass"])) {
            die("Password must contain at least one letter");
        }
        
        if ( ! preg_match("/[0-9]/", $_POST["pass"])) {
            die("Password must contain at least one number");
        }
        
        $password_hash = password_hash($_POST["pass"], PASSWORD_DEFAULT);
        $create_datetime = date("Y-m-d H:i:s");

        $host = "localhost";
        $dbname = "LoginSystem";
        $username = "root";
        $password = "";

        $mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
        // $mysqli = require __DIR__ . "/db.php";
        
        $sql = "INSERT into users (username, email, password_hash, create_datetime)
        VALUES (?, ?, ?, ?)";
                
        $stmt = $mysqli->stmt_init();
        
        if ( ! $stmt->prepare($sql)) {
            die("SQL error: " . $mysqli->error);
        }
        
        $stmt->bind_param("ssss",
                          $_POST["name"],
                          $_POST["email"],
                          $password_hash,
                          $create_datetime);
                          
        if ($stmt->execute()) {
        
            header("Location: signin.php");
            exit;
            
        } else {
            if ($mysqli->errno === 1062) {
                die("email already taken");
            } else {
                die($mysqli->error . " " . $mysqli->errno);
            }
        }

