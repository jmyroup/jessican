<?php
require 'auth.php';
session_destroy();
print "You have logged out | ";
print '<a href="login.php">Login again?</a>';
?>
