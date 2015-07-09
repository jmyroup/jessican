<?php
$page_title = 'View Your Shopping Cart';
include ('header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	foreach ($_POST['qty'] as $k => $v) {
		$pid = (int) $k;
		$qty = (int) $v;
		if ($qty == 0) {
		unset ($_SESSION['cart'][$pid]);
		} elseif ($qty > 0) {
			$_SESSION['cart'][$pid]['quantity'] = $qty;
		}
	}
}

if (!empty($_SESSION['cart'])) {
	echo '<form action="view_cart.php" method="post">
	<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
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
					<td align=\"right\"><input type=\"text\" size=\"3\" name=\"qty[$pid]\" value=\"{$_SESSION['cart'][$pid]['quantity']}\" /></td>
					<td align=\"right\">$". number_format ($subtotal, 2) . "</td>
				</tr>\n";
	}
	echo '<tr>
			<td colspan="3" align="right"><b>Total:</b></td>
			<td align="right">$' . number_format ($total, 2) . '</td>
		</tr>
		</table>
		<div align="center"><input type="submit" name="submit" value="Update My Cart" /></div>
		</form><p align="center">Enter a quantity of 0 to remove an item.<br /><br /><a href="products.php">Continue Shopping</a><br /><br /><a href="checkout.php">Checkout</a></p>';
} else {
	echo '<p>Your cart is currently empty.</p>';
}


include ('footer.html');
?>
