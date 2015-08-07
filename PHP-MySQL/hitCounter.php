<?php
$dbHost = "127.0.0.1";
$dbUser = "jess";
$dbPass = "password";
$dbDatabase = "guestbook";
// Connect to DB
$db = mysqli_connect($dbHost, $dbUser, $dbPass, $dbDatabase) or die("Could not connect");

$query = mysqli_query($db, "UPDATE hitcounter SET hits = hits + 1");
$query = mysqli_query($db, "SELECT hits FROM hitcounter");
$rows = mysqli_fetch_array($query);
$hits = $rows['hits'];
echo "Visitors: " . $hits . '';
 
mysqli_free_result($query);
mysqli_close($db);
?>
