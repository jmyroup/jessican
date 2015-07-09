<?php
$page_title = 'Order Confirmation';
include ('header.html');

function save_order($data) {
	$order = print_r($_SESSION['cart'], true);
	$file = @fopen('./orders.txt','a');
	if($file == NULL) {
		return false;
	} 
	date_default_timezone_set('America/Los_Angeles');
	fwrite($file, "Name: " . $_POST['first_name'] . " " . $_POST['last_name'] . "\nEmail: " . $_POST['email'] . "\nPhone: " . $_POST['phone'] . "\nOrder submitted: " . date('Y.m.d h:i:sa') . "\n" . $order . "\n\n");
	fclose($file);
	return true;
}

function validate_form($data) {
	$errors = array();	

	//trim text of white space & strip phone number of non-numbers
	$first_name = trim($_POST["first_name"]);
	$last_name = trim($_POST["last_name"]);
	$email = trim($_POST["email"]);
	$phone = preg_replace("/\D/", "", $_POST["phone"]);
	
	//email field must look like an email address & must be non-empty
	if (empty($email)) {
		$errors[] = "Please enter your email address";
	} elseif (!preg_match("/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i",$email)) {
			$errors[] = "Invalid email format";
	} else {
			$email = $_POST["email"];
	}
	
	//phone field, if not empty, must contain exactly 10 digits
	if (empty($phone)) {
		$errors[] = "Please enter your phone number";
	} elseif (!empty($phone) && strlen($phone) < 10) {
		$errors[] = "Your phone number must be 10 digits in length";
	} else {
		$phone = $_POST["phone"];
	}
	
	//first name field must be non-empty & must not exceed 30 characters in length
	if (empty($first_name)) {
		$errors[] = "Please enter your first name";
	} elseif (strlen($first_name) > 30) {
		$errors[] = "Your first name exceeds the maximum length of 30 characters";
	} else {
		$first_name = $_POST["first_name"];
	}

	//last name field must be non-empty & must not exceed 30 characters in length
	if (empty($last_name)) {
		$errors[] = "Please enter your first name";
	} elseif (strlen($last_name) > 30) {
		$errors[] = "Your first name exceeds the maximum length of 30 characters";
	} else {
		$last_name = $_POST["last_name"];
	}

	return $errors;
}

function process($data) {
	$to = $_POST['email'];
	$subject = "Your school supply order";
	$body = "Thank you for your order, {$_POST['first_name']} {$_POST['last_name']}! Your items should arrive in 2-3 business days.";
	mail($to, $subject, $body, "From: {$_POST['email']}");
	echo '<p align="center">Thank you for your order. You will receive a confirmation email shortly.</p>';
	echo '<p align="center"><a href="products.php">Shop Again?</a></p>';
	session_unset();
	session_destroy();
}

function review_order() {
	if (!empty($_SESSION['cart'])) {
	echo '<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
		<tr>
			<td align="left" width="25%"><b>Product</b></td>
			<td align="center" width="25%"><b>Price</b></td>
			<td align="right" width="25%"><b>Quantity</b></td>
			<td align="right" width="25%"><b>Total Price</b></td>
		</tr>';
	$total = 0;
	foreach($_SESSION['cart'] as $key => $value){
		$name = $value['name'];
		$price = $value['price'];
		$quantity = $value['quantity'];
		$pid = $value['pid'];
		$subtotal = $_SESSION['cart'][$pid]['quantity'] * $_SESSION['cart'][$pid]['price'];
		$total += $subtotal;
		echo "\t<tr>
					<td align=\"left\">{$_SESSION['cart'][$pid]['name']}</td>
					<td align=\"center\">\${$_SESSION['cart'][$pid]['price']}</td>
					<td align=\"right\">{$_SESSION['cart'][$pid]['quantity']}</td>
					<td align=\"right\">$". number_format ($subtotal, 2) . "</td>
				</tr>\n";
	}
	echo '<tr>
			<td colspan="3" align="right"><b>Total:</b></td>
			<td align="right">$' . number_format ($total, 2) . '</td>
		</tr>
		</table><br /><br />';
	echo '<form action="checkout.php" method="post">
		<table>
			<tr>
				<td>First Name:</td>
				<td><input type="text" name="first_name" size="30" value=""/></td>
			</tr>
			<tr>
				<td>Last Name:</td>
				<td><input type="text" name="last_name" size="30" value=""/></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input type="text" name="email" size="30" value=""/></td>
			</tr>
			<tr>
				<td>Phone number:</td>
				<td><input type="text" name="phone" size="30" value=""/></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" value="Submit Order" /></td>
			</tr>
		</table></form>';
	} else {
		echo '<p>Your cart is currently empty.</p>';
	}
}

if ($_POST) {
	
	$errors = validate_form($_POST);
	
	if ($errors) {
		echo "<p>Sorry, we are unable to process your submission because:</p><ul><li>",
				implode('</li><li>',$errors),
				"</li></ul>",
				"<p>Please correct your form below and re-submit it</p>";
		review_order($_POST);
		
	} else {
		save_order($_POST);
		process($_POST); 	
	}
} else {
	review_order();
}

include ('footer.html');
?>
