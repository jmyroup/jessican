<?php 

session_start();

if(!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']))) {
	require ('includes/login_functions.inc.php');
	redirect_user();
}

$page_title = 'Members Only!';
include ('includes/header.html');

echo "<h3>Logged in!</h3>
	<p>You are now logged in, {$_SESSION['first_name']}, and can see all of our members only stuff!</p>
	<p>Click <a href=\"logout.php\">here</a> to log out.</p>";
	
include ('includes/footer.html');
?>
