<?php
$page_title = 'Add to Cart';
include ('header.html');

if (isset ($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
	$pid = $_GET['pid'];
	$price = $_GET['price'];
	$name = $_GET['name'];
	
	if (isset ($_SESSION['cart'][$pid])) {
		$_SESSION['cart'][$pid]['quantity']++;
		echo '<p align="center">Another of this item has been added to your cart.</p>';
		echo '<p align="center"><a href="products.php">Continue Shopping</a><br /><br /><a href="view_cart.php">View Cart & Checkout</a></p>';
	} else {
		$_SESSION['cart'][$pid] = array ('pid' => $pid, 'quantity' => 1, 'price' => $price, 'name' => $name);
		echo '<p align="center">This item has been added to your cart.</p>';
		echo '<p align="center"><a href="products.php">Continue Shopping</a><br /><br /><a href="view_cart.php">View Cart & Checkout</a></p>';
	}
}

include ('footer.html');
?>
