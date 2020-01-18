<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('includes/header.php');
include('includes/nav.php');
$message = "FUCK OFF";
$email = "kaguyasama27@gmail.com";
$subject = "";
$headers = "";
var_dump(send_email($email,$subject,$message,$headers));
