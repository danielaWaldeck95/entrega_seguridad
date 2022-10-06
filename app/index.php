<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user'])){ //if login in session is not set
    header("Location: /views/login.php");
}