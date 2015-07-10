<?php
session_start();
if(!$_SESSION['username']){
	header("Location: http://". $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "login.php");
	exit;
} else {
		$username = $_SESSION['username'];}
?>
