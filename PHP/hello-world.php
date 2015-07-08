<?php if (isset($_GET['phpinfo'])) {
	ob_start();
	phpinfo();
	$data = ob_get_clean();
	$data = preg_replace(
		'|</body>|i',
		"<p style=\"text-align:center\"><a href=\"$_SERVER[PHP_SELF]
		\">Hide php info</a></p></body>",
		$data
		);
	echo $data;
	exit;
}
echo '<?xml version="1.0" encoding="iso-8859-1"?>'?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Week 1</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>
	<body style="font-family:sans-serif;margin-left:100px;marginright:100px;">
		<h2>Hello World</h2>
		<p>Current date and time: <?php echo date('l, F d, Y h:i:s a'); ?>. I am proudly running PHP version <?php echo PHP_VERSION ;?> with <?php echo $_SERVER['SERVER_SOFTWARE'];?>
		<p>For full details, <a href="<?php echo $_SERVER['PHP_SELF'] . '?phpinfo' ?>">view the output of my phpinfo().</a></p>
	</body>
	</html>
