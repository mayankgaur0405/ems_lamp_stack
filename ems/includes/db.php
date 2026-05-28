<?php

$host_name = "localhost";
$user_name = "root";
$user_pass = "";
$db_name = "ems_db";

$conn =  mysqli_connect($host_name, $user_name, $user_pass, $db_name);

if (!$conn) {
    die("database connection failed" . mysqli_connect_error());
}

// echo "Database connected successfully";
