<?php
// refer to https://classes.engineering.wustl.edu/cse330/index.php?title=PHP_and_MySQL#Connecting_to_a_MySQL_Database_in_PHP
$mysqli = new mysqli('localhost', 'Ganshuwei', 't19971219', 'newsDB');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

$conn=mysqli_connect('localhost', 'Ganshuwei', 't19971219', 'newsDB');

?>