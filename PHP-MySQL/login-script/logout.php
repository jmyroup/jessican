<?php 

session_start();

if(!isset($_SESSION['user_id'])) {
	require ('includes/login_functions.inc.php');
	redirect_user();
} else {
	$_SESSION = array();
	session_destroy();
}

$page_title = 'Logged Out!';
include ('includes/header.html');

echo "<h3>Logged Out!</h3>
	<p>Thanks for stopping by!</p>";
	
include ('includes/footer.html');
?>
