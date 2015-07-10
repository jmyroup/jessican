<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	require ('includes/login_functions.inc.php');
	require ('includes/mysqli_connect.php');
	
	list($check, $data) = check_login($dbc, $_POST['email'], $_POST['password']);
	
	if($check) {
		session_start();
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['first_name'] = $data['first_name'];
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		redirect_user('loggedin.php');
	} else {
		$errors = $data;
	}
	mysqli_close($dbc);
}

include ('includes/login_page.inc.php');
?>
