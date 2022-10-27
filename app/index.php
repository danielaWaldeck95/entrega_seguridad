<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user'])){ //if login in session is not set
    header("Location: /views/login.php");
} else {
    $user_id = $_SESSION['user'];
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn -> query($sql);
    $user = $result -> fetch_assoc();
}