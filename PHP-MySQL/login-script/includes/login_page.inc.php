<?php 

$page_title = 'Login';
include ('includes/header.html');

//Print any error messages
if (isset($errors) && !empty($errors)) {
	echo '<h3>Error!</h3>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) {
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
}

//Display the form
?>
<h3>Login</h3>
<form action="login.php" method="post">
	<p>Email Address: <input type="text" name="email" size="20" maxlength="60" /></p>
	<p>Password: <input type="password" name="password" size="20" maxlength="20" /></p>
	<p><input type="submit" name="submit" value="Login" /></p>
</form>

<?php include ('includes/footer.html'); ?>
