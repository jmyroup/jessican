<?php 
require 'formhelpers.php';

// This is identical to the input_text() function in formhelpers.php but
// prints a password box (in which asterisks obscure what's entered)
// instead of a plain text field

function input_password($field_name, $values) {
	print '<input type="password" name="' . $field_name . '" value=""">';
}

session_start();
if (isset($_POST['_submit_check'])) {
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        process_form();
    } 
} else {
    show_form();
}

function show_form($errors = '') {
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

    if ($errors) {
        print '<ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    } 
    print 'Username: ';
    input_text('username', $_POST);
    print '<br/>';

    print 'Password: ';
    input_password('password', $_POST);
    print '<br/>';

    input_submit('submit','Log In');

    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function validate_form() {
    $errors = array();

    // Some sample usernames and passwords
    $users = array('alice'   => 'dog123',
                   'bob'     => 'my^pwd',
                   'charlie' => '**fun**');
    
    // Make sure user name is valid
    if (!array_key_exists($_POST['username'], $users)) {
        $errors[] = 'Please enter a valid username and password.';
    } 
                                   
    // See if password is correct
    elseif ($saved_password = $users[$_POST['username']]) {
    if ($saved_password != $_POST['password']) {
        $errors[] = 'Please enter a valid username and password.';
    }}

    return $errors;
}


function process_form() {
    // Add the username to the session
    $_SESSION['username'] = $_POST['username'];

    print "Welcome, $_SESSION[username]";
	print '<br /><br />';
	print '<a href="1.php">page one</a> | ';
	print '<a href="2.php">page two</a> | ';
	print '<a href="3.php">page three</a> | ';
	print '<a href="logout.php">logout</a>';
	
}
?>
