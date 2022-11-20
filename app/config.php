<?php
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname,$username,$password,$db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
//Logs
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_log', 'php_error.log');
