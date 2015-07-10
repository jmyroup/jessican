<?php 

$page_title = 'Register';
include ('includes/header.html');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('includes\mysqli_connect.php');
	$errors = array();
	
	if(empty($_POST['first_name'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}
	
	if(empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}
	
	if(empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	
	if(!empty($_POST['pass1'])) {
		if($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}
	
	if(empty($errors)) {
		
		//Register the user in the database
		
		$q = "INSERT INTO members (first_name, last_name, email, password)
				VALUES ('$fn', '$ln', '$e', md5('$p'))";
		
		$r = @mysqli_query ($dbc, $q);
		if ($r) {
			echo '<h3>Thank you! You are now registered and can login <a href="login.php">here</a>.</h3>';
		} else {
			echo '<h3>System Error. You could not be registered at this time.</h3>';
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
		}
		mysqli_close($dbc);
		include ('includes/footer.html');
		exit();
	} else {
		echo '<h3>Error!</h3>
			<p class="error">The following error(s) occurred:<br />';
			foreach ($errors as $msg) {
				echo " - $msg<br />\n";
			}
		echo '</p><p>Please try again.</p><p><br /></p>';
	}
	
	mysqli_close($dbc);
}
?>

<h3>Register</h3>
<form action="register.php" method="post">
	<p>First Name: <input type="text" name="first_name" size="15" maxlength="20" value="<?php  if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>
	<p>Last Name: <input type="text" name="last_name" size="15" maxlength="20" value="<?php  if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
	<p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php  if(isset($_POST['email'])) echo $_POST['email']; ?>" /></p>
	<p>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php  if(isset($_POST['pass1'])) echo $_POST['pass1']; ?>" /></p>
	<p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php  if(isset($_POST['pass2'])) echo $_POST['pass2']; ?>" /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
	</form>
<?php include ('includes/footer.html'); ?>	
