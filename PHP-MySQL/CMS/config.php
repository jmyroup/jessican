<?php 
ini_set("display_errors", true);
error_reporting(E_ALL ^ E_DEPRECATED);
date_default_timezone_set("America/Los_Angeles");
define("DB_DSN", "mysql:host=localhost;dbname=cms");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "secret");
define("CLASS_PATH", "classes");
define("TEMPLATE_PATH", "templates");
define("HOMEPAGE_NUM_ARTICLES", 5);
define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", "admin");
require(CLASS_PATH . "/Article.php");

function handleException($exception) {
	echo "Sorry, a problem occurred. Please try again later.";
	error_log($exception->getMessage());
}

set_exception_handler('handleException');
?>
