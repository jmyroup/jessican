<?php
include('guestbook.inc');

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
