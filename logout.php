<?php
session_start();
	unset($_SESSION['ADMIN_AREA']);
	unset($_SESSION['ADMIN_USER']);
	//$_SESSION['MESSAGE']="You have successfully logged out.";
	
	//remove all the variables in the session 
 session_unset(); 
 
 // destroy the session 
 session_destroy();  
 
	header("Location:index.php");
	exit;
?>