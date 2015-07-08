<?php echo '<?xml version="1.0" encoding="iso-8859-1"?>'?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Web Development with PHP: Session Two</title>
	<style type="text/css">
		body {
			font-family : verdana, arial, helvetica, sans-serif;
			font-size : small;
			line-height : 120%;
			margin-left: 20%;
		}

		form, textarea {
			font-family : verdana, arial, helvetica, sans-serif;
			font-size : small;
		}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body style="margin-top:80px">

	<?php if (!empty($_POST)): ?>
		Your name: <?php $name = $_POST['your_name'];
		if (empty($name)) : echo "[no value]";
		else : echo htmlspecialchars($name);
		endif; ?><br>
    
		Comments: <?php $comments = $_POST['comments'];
		if (empty($comments)) : echo "[no value]";
		else : echo htmlspecialchars($comments);
		endif; ?><br>
    
		Gender: <?php echo $_POST["gender"]; ?><br>
   
		Beverage preference: <?php 
		if (isset($_POST['beverage'])) : echo $_POST["beverage"]; 
		else : echo "[no value]";
		endif; ?><br>
    
		Spam? <?php 
		if (isset($_POST['wants_spam'])) : echo "Please spam me mercilessly!"; 
		else : echo "[no value]"; 
		endif;
		exit; ?><br>

	<?php else: ?>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<table>
				<tr valign="middle">
					<td align="right">Your name</td>
					<td><input name="your_name" type="text" size="20" /></td>
				</tr>
				<tr valign="top">
					<td align="right">Comments</td>
					<td><textarea name="comments" rows="3" cols="40"></textarea></td>
				</tr>
				<tr valign="middle">
					<td align="right">Gender</td>
					<td>
					  <select name="gender">
						<option value="[no value]">[select one]</option>
						<option value="male">male</option>
						<option value="female">female</option>
						<option value="none of your business">none of your business</option>
					  </select>
					</td>
				</tr>
				<tr valign="top">
					<td align="right">Beverage preference</td>
					<td>
					  <input type="radio" name="beverage" value="coffee" />coffee &nbsp;&nbsp;
					  <input type="radio" name="beverage" value="tea" />tea &nbsp;&nbsp;
					  <input type="radio" name="beverage" value="beer" />beer &nbsp;&nbsp;
					</td>
				</tr>
				<tr valign="top">
					<td align="right">&nbsp;</td>
					<td><input type="checkbox" name="wants_spam"/>Please spam me mercilessly</td>
				</tr>
				<tr valign="top">
					<td colspan="2" align="center">
					  <input type="submit" value="Submit" />
					  <input type="hidden" name="hidden_field" value="_submitted" />
					</td>
				</tr>
			</table>
		</form>
	<?php endif; ?>
</body></html>
