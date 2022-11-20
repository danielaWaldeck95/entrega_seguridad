<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user'])){ //if login in session is not set
    header("Location: /views/login.php");
} else {
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT * FROM users WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
  
    $user_id = $_SESSION['user'];

  
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
      $stmtResult = $stmt->get_result();
      $user = $stmtResult->fetch_array();
    }
}