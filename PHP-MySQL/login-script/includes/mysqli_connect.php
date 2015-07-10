<?php 

$server = "localhost";
$username = "root";
$password = "secret";
$database = "login";
$table = "members";

$dbc = @mysqli_connect($server, $username, $password, $database) 
		OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
		
mysqli_set_charset($dbc, 'utf8');
