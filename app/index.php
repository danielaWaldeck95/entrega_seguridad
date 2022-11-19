<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user'])){ //if login in session is not set
    header("Location: /views/login.php");
} else {
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "DELETE FROM products WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
   
    $id = $_SESSION['user'];

    mysqli_stmt_execute($stmt);
   
    mysqli_stmt_close($stmt);
}