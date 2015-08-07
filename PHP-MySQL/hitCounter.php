<?php
$dbHost = "127.0.0.1";
$dbUser = "jess";
$dbPass = "password";
$dbDatabase = "guestbook";

// Connect to DB

$db = mysqli_connect($dbHost, $dbUser, $dbPass, $dbDatabase);
 
if ($db ->connect_errno > 0){
    die('Could not select DB');
}
$db->select_db("hitcounter");
$update_query = "update hitcounter set hits = hits + 1";
 
if (!$results = $db->query($update_query)){
    die('Error running query ' . $db->error );
}
 
$counter_query = "select hits from hitcounter";
$get_hits = $db->query($counter_query);
 
while ($row = $get_hits->fetch_assoc()){
    echo "Number of visits: " . $row["hits"];
}
 
$get_hits->free();
$db->close();
?>
