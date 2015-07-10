<?php
/* Week 4 Homework Assignment
*/
error_reporting(E_ALL);
$subject_options = array(''=>'[select one]','rant'=>'rant','praise'=>'praise','question'=>'question','observation' =>'observation');
$defaults = array('subject'=>'','comments'=>'','name'=>'','email'=>'');

function display_comments() {
	$handle = @fopen('./comments.txt','r');
	if($handle == NULL) {
		return false;
	}
	while (!feof($handle)) {
		$contents = fgets($handle);
		$contents = htmlentities($contents);
		$contents = str_replace('\n','<br \>',$contents);
		print $contents;
	}
	fclose($handle);
	return true;
}

function save_comment($data) {
	$file = @fopen('./comments.txt','a');
	if($file == NULL) {
		return false;
	} 
	date_default_timezone_set('America/Los_Angeles');
	fwrite($file, $_POST['comments'] . '\nSubject: ' . $_POST['subject'] . ' Posted at: ' . date('Y.m.d h:i:sa') . ' by ' . $_POST['name'] . '\n\n' . "\n");
	fclose($file);
	return true;
}

function validate_form(&$data) {

	$errors = array();

	$data['email']=trim($data['email']);
	$data['comments']=trim($data['comments']);
	$data['name']=trim($data['name']);

	if (empty($data['email'])) {
		$errors[] = "Email address is required";
	} elseif (! preg_match( '/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i',$data['email'])) {
		$errors[] = 'Email address appears to be invalid';
	}

	if (empty($data['comments'])) {
		$errors[] = 'The comments field is required';
	}

	if (strlen($data['comments']) > 250 )  {
		$errors[] = 'The comments field exceeds the maximum length';
	}

	$data['comments'] = strip_tags($data['comments']);

	$data['name'] = strip_tags($data['name']);
	if (! strlen($data['name'])) { 
		$data['name'] = 'anonymous'; 
	}

	if (strlen($data['name']) > 36) {
		// truncate it
		$data['name'] = substr($data['name'],0,36);
		$errors[] = 'Your name exceeds the max field length';
	}
	if (empty($data['subject'])) {
		$errors[] = 'Subject field is required';
	}

	if (! array_key_exists($data['subject'],$GLOBALS['subject_options'])) {

		$errors[] = 'Invalid subject field';
	}
	return $errors;
}

function input_select($element_name, $selected, $options, $multiple = false) {
	// print out the <select> tag
	print '<select name="' . $element_name;
	// if multiple choices are permitted, add the multiple attribute
	// and add a [] to the end of the tag name
	if ($multiple) {
		print '[]" multiple="multiple';
	}
	print '">';

	// set up the list of things to be selected
	$selected_options = array();
	if ($multiple) {
		foreach ($selected[$element_name] as $val) {
			$selected_options[$val] = true;
		}
	} else {
		$selected_options[ $selected[$element_name] ] = true;
	}

	// print out the <option> tags
	foreach ($options as $option => $label) {
		print '<option value="' . htmlentities($option) . '"';
		if (isset($selected_options[$option])) {
			print ' selected="selected"';
		}
		print '>' . htmlentities($label) . '</option>';
	}
	print '</select>';
}

function display_form($defaults) {

	global $subject_options;
?>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table>
	<tr><td>
		Subject
		</td>
		<td> 
		<?php input_select('subject',$defaults,$subject_options)?>
		</td>
	</tr>
	<tr>
		<td>Your email
		</td>
		<td> <input type="text" name="email" size="30" value="<?php echo htmlspecialchars($defaults['email'])?>"/>
		</td>
	</tr>
	<tr>
		<td>Your name
		</td>
		<td> <input type="text" name="name" size="30" value="<?php echo htmlspecialchars($defaults['name'])?>"/>
		</td>
	</tr>
		<tr>
		<td valign="top">Comments 
		</td>
		<td><textarea name="comments" cols="40" rows="5"><?php echo htmlspecialchars($defaults['comments'])?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="Submit Comments" /></td>
	</tr>
	</table>
	</form>
<?php 
}

if ($_POST) {

	$errors = validate_form($_POST);

	if ($errors) {

		echo "<p>Sorry, we are unable to process your submission because:</p><ul><li>",
		implode('</li><li>',$errors),
		"</li></ul>",
		"<p>Please correct your form below and re-submit it</p>";
		display_form($_POST);

	} else {

		save_comment($_POST) or die("Sorry, our guestbook is out of order. Please try again later");
		display_comments() or die("Sorry, our guestbook is out of order. Please try again later");
		display_form($defaults);
	}

} else {
	
	display_comments() or die("Sorry, our guestbook is out of order. Please try again later");
	display_form($defaults);

}
 ?>
