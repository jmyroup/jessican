<?php
$dbHost = "127.0.0.1:3306";
$dbUser = "jess";
$dbPass = "password";
$dbDatabase = "guestbook";

// Connect to DB

$li = mysql_connect($dbHost, $dbUser, $dbPass) or die("Could not connect");
mysql_select_db($dbDatabase, $li) or die("could not select DB");

// initiate some vars

$gb_str = ""; 	// $gb_str is the string we'll append entries to
$pgeTitle = "View and Sign Guestbook";

// If form is submitted, then insert into DB
if (!empty($_POST["submit"])) {
	$name = $_POST["gbName"];
	$email = $_POST["gbEmail"];
	$comment = $_POST["gbComment"];
	$date = Date("Y-m-d h:i:s");
	
	$gb_query = "insert into guestbook (gbName, gbEmail, gbComment, gbDateAdded) values ('$name', '$email', '$comment', '$date')";
	
	mysql_query($gb_query);
	$res = mysql_affected_rows();
	
	// See if insert was successful or not
	if($res > 0) {
		$ret_str="Your guestbook entry was successfully added.";
	} else {
		$ret_str = "Your guestbook entry was NOT successfully added.";
	}
	
	// Append success/failure message
	$gb_str .= "<span class=\"ret\">$ret_str</span><BR>";
	echo mysql_error();
}

// The querystring
$get_query = "select gbName, gbEmail, gbComment, DATE_FORMAT(gbDateAdded, '%m-%d-%y %H:%i') gbDateAdded
		from guestbook";

$get_rs = mysql_query($get_query);
$gb_str .= "<hr size=\"1\">";

// While there are still results
while($get_row = mysql_fetch_array($get_rs)) {
	$name = $get_row["gbName"];
	$email = $get_row["gbEmail"];
	$comment = $get_row["gbComment"];
	$date = $get_row["gbDateAdded"];
	
	if(!empty($name)) {
		// If name exists and email exists, link name to email
		if(!empty($email)) {
			$name="by <a href=\"mailto:$email\">$name</a>";
		}
	// If name does exist and email exists, link email to email		
	} elseif (!empty($email)) {
		$name = "by <a href=\"mailto:$email\">$email</a>";
	// Else make name blank 
	} else {
		$name = "";
	}
	
	// Append to string we'll print later on
	$gb_str .= "<br>$comment<p class=\"small\">< posted on $date $name><hr size=\"1\">";
}

// Free Result Memory
mysql_free_result($get_rs);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<TITLE>Guestbook</TITLE>
	<SCRIPT language="javascript"><!--

	/* This function is pulled from a generic validation file from
	some other site (probably developer.netscape.com) and strips out
	characters you don't want */

	function stripCharsInBag (s, bag) {
		var i;
    	var returnString = "";

    	// Search through string's characters one by one.
    	// If character is not in bag, append to returnString.

    	for (i = 0; i < s.length; i++)
    	{   
        	// Check that current character isn't whitespace.
        	var c = s.charAt(i);
        	if (bag.indexOf(c) == -1) returnString += c;
    	}
    	return returnString;
	}

	// This function just makes sure the comment field is not empty

	function valForm(frm) {
		badChars = "<[]>{}";
		if(frm.gbComment.value == "") {
			alert("Please fill in your comments for the guestbook.");
			return false;
		} else {
			frm.gbComment.value = stripCharsInBag(frm.gbComment.value, badChars);
			// These values may be empty, but strip chars in case they're not
			frm.gbName.value = stripCharsInBag(frm.gbName.value, badChars);
			frm.gbEmail.value = stripCharsInBag(frm.gbEmail.value, badChars);
			return true;
		}
	}

	--></SCRIPT>
</HEAD>
<BODY bgcolor="#FFFFFF"><?php echo $gb_str; ?><form name="gb" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">		
	<table cellpadding="3" cellspacing="0" border="0">
    	<tr>
        	<td class="tdhead" valign="top" align="right">Name</td>
            <td valign="top"><input type="text" name="gbName" value="" size="30" maxlength="50"></td>
        </tr>
        <tr>
        	<td class="tdhead" valign="top" align="right">Email</td>
            <td valign="top"><input type="text" name="gbEmail" value="" size="30" maxlength="100"></td>
        </tr>
        <tr>
        	<td class="tdhead" valign="top" align="right">Comment</td>
            <td valign="top"><textarea name="gbComment" rows="5" cols="30"></textarea></td>
        </tr>
        <tr>
        	<td></td>
            <td><input type="submit" name="submit" value="submit" onClick="return valForm(document.gb)"><input type="reset" name="reset" value="reset"></td>
        </tr>
    </table></form>
</BODY>
</HTML>

<?php
// Close MySQL Connection
mysql_close($li);
?> 
