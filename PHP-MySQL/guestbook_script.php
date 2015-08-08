<?php
$dbHost = "127.0.0.1:3306";
$dbUser = "jess";
$dbPass = "password";
$dbDatabase = "guestbook";

// Connect to DB
$li = mysqli_connect($dbHost, $dbUser, $dbPass, $dbDatabase) or die("Could not connect");

// initiate some vars
$gb_str = ""; 	// $gb_str is the string we'll append entries to
$pgeTitle = "View and Sign Guestbook";

// If form is submitted, validate the data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_POST["gbName"] = htmlentities(strip_tags($_POST["gbName"]));
	$_POST["gbEmail"] = htmlentities(strip_tags($_POST["gbEmail"]));
	$_POST["gbComment"] = htmlentities(strip_tags($_POST["gbComment"]));
	
	// spam purification
	function spam_scrubber($value) {
		
		// List of very bad values
		$very_bad = array("to:", "cc:", "bcc:", "content-type:", "mime-version:", "multipart-mixed:", "content-transfer-encoding:");
		// If present, return an empty string
		foreach ($very_bad as $v) {
			if (stripos($value, $v) !== false) return "";
		}
		
		// Replace any newline characters with spaces
		$value = str_replace(array( "\r", "\n", "%0a", "%0d"), " ", $value);
		
		// Return the value
		return trim($value);
	} // end of spam_scrubber() function
	
	// clean the form data
	$scrubbed = array_map("spam_scrubber", $_POST);

	// Handle the form
	if (!empty($scrubbed["gbComment"])) {
	
		// Create the query
		$gb_query = "INSERT INTO guestbook (gbName, gbEmail, gbComment, gbDateAdded) VALUES (?, ?, ?, NOW())";
		
		// Prepare the statement
		$stmt = mysqli_prepare($li, $gb_query);
		
		// Bind the variables:
		mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $comment);
		
		// Assign values to the variables
		$name = $scrubbed["gbName"];
		$email = $scrubbed["gbEmail"];
		$comment = $scrubbed["gbComment"];
		
		// Execute the query
		mysqli_stmt_execute($stmt);		
	
		$res = mysqli_stmt_affected_rows($stmt);
	
		// See if insert was successful or not
		if($res == 1) {
			$ret_str = "Your guestbook entry was successfully added.";
		} else {
			$ret_str = "Your guestbook entry was NOT successfully added.";
		}
	
		// Append success/failure message
		$gb_str .= "<span class=\"ret\">$ret_str</span><br />";
	}
}

// Get entries from database
$get_query = "SELECT gbName, gbEmail, gbComment, DATE_FORMAT(gbDateAdded, '%m-%d-%y %H:%i') gbDateAdded
		FROM guestbook";
$get_rs = mysqli_query($li, $get_query);
$gb_str .= "<hr size=\"1\" />";

// While there are still results
while($get_row = mysqli_fetch_array($get_rs)) {
	$name = strip_tags($get_row["gbName"]);
	$email = strip_tags($get_row["gbEmail"]);
	$comment = strip_tags($get_row["gbComment"]);
	$date = $get_row["gbDateAdded"];
	
	if(!empty($name)) {
		// If name exists and email exists, link name to email
		if(!empty($email)) {
			$name="<a href=\"mailto:$email\">$name</a>";
		}
	// If name does not exist and email exists, link email to email		
	} elseif (!empty($email)) {
		$name = "<a href=\"mailto:$email\">$email</a>";
	// Else make name Anonymous 
	} else {
		$name = "Anonymous";
	}
	
	// Append to string we'll print later on
	$gb_str .= "<br />$comment<p class=\"small\">< posted on $date by $name ></p><hr size=\"1\" />";
}

// Hitcounter
$query = mysqli_query($li, "UPDATE hitcounter SET hits = hits + 1");
$query = mysqli_query($li, "SELECT hits FROM hitcounter");
$rows = mysqli_fetch_array($query);
$hits = $rows['hits'];
 
// Free Result Memory
mysqli_free_result($get_rs);
mysqli_free_result($query);

// Close MySQL Connection
mysqli_stmt_close($stmt);
mysqli_close($li);
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Josefin+Slab|Libre+Baskerville|Port+Lligat+Slab' rel='stylesheet' type='text/css' />
	<title>Guestbook</title>
</head>
<body bgcolor="#FFFFFF">
	<h1>Please feel free to leave feedback!</h1>
	<form name="gb" action="guestbook.php" method="post">		
		<table cellpadding="3" cellspacing="0" border="0">
    		<tr>
        		<td class="tdhead" valign="top" align="right">Name</td>
            	<td valign="top"><input type="text" name="gbName" value="" size="30" maxlength="50" /></td>
        	</tr>
        	<tr>
        		<td class="tdhead" valign="top" align="right">Email</td>
            	<td valign="top"><input type="text" name="gbEmail" value="" size="30" maxlength="100" /></td>
        	</tr>
        	<tr>
        		<td class="tdhead" valign="top" align="right">Comment</td>
            	<td valign="top"><textarea name="gbComment" rows="5" cols="30" required></textarea></td>
        	</tr>
        	<tr>
        		<td></td>
            	<td><input type="submit" name="submit" value="submit" />
                <input type="reset" name="reset" value="reset" /></td>
        	</tr>
    	</table>
    </form>
    <br />
	<?php echo $gb_str; ?>
    <br />
    <br />
	Visitors: <?php echo $hits; ?>
    <br /><br />
    <a href="../../../projects.php">Click here to return to the projects page</a>
</body>
</html>
