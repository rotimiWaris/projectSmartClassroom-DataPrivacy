<?php

$host = "localhost";
$dbname = "LoginSystem";
$username = "root";
$password = "";

$mysqli = new mysqli(hostname: $host,
                username: $username,
                password: $password,
                database: $dbname);
    // Enter your host name, database username, password, and database name.
    // If you have not set database password on localhost then set empty.
    if ($mysqli->connect_errno) {
        die("Connection error: " . $mysqli->connect_error);
    }
    
    return $mysqli;
?>