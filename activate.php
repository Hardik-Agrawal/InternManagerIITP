<?php 
include('includes/header.php') ;
if(isset($_GET['type'])){
	$type = $_GET['type'];
	$email =$_GET['email'];
	if($type == 2);
	add_student($email);
}
activate_user();
