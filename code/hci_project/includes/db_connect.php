<?php
include_once 'psl-config.php';   // As functions.php is not included
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
if($conn->connect_errno > 0){
    die('Unable to connect to database [' . $conn->connect_error . ']');
}
$conn->set_charset("utf8mb4");
