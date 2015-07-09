<?php
$page_title = "What's for sale?";
include ('header.html');

	$products = array (
		array("pid" => "1", "name" => "Pencil", "price" => "0.49", "description" => "Just your basic yellow #2 pencil"),
		array("pid" => "2", "name" => "Pen", "price" => "0.99", "description" => "A pretty nice fine point black ink pen"),
		array("pid" => "3", "name" => "Notebook", "price" => "1.99", "description" => "A red, college-rule 70 page spiral notebook"),
		array("pid" => "4", "name" => "Laptop", "price" => "599.99", "description" => "Basically a way more expensive notebook"),	
	);

echo "<p align='center'><b>Click the name of any item to add it to your cart:</b></p>";
echo '<table border="0" width="90%" cellspacing="3" align="center">
		<tr>
			<td align=left width="20%"><b>Product</b></td>
			<td align=left width="60%"><b>Description</b></td>
			<td align=right width="20%"><b>Price</b></td>
		</tr>';
foreach($products as $key => $value){
	$name = $value['name'];
	$price = $value['price'];
	$desc = $value['description'];
	$pid = $value['pid'];
	echo "\t<tr>
				<td align=\"left\"><a href='add_cart.php?pid=$pid&name=$name&price=$price'>$name</a></td>
				<td align=\"left\">$desc</td>
				<td align=\"right\">\$$price</td>
			</tr>\n";
}
echo '</table><br />';
echo '<p align="center"><a href="view_cart.php">View Cart & Checkout</a></p>';
include ('footer.html');
?>
