<?php
session_start();
if($_SESSION["ADMIN_USER"]!="Active")
	{
		header('Location:index.php');
		exit();
	}
 ?>