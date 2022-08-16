<?php
ini_set("session.cookie_httponly", 1);
require 'database.php';

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$event_name = $json_obj['event_name'];
$year = $json_obj['year'];
$month = $json_obj['month'];
$day = $json_obj['day'];
$username = $json_obj['username'];
$categorial = $json_obj['categorial'];

$to_insert = $mysqli->prepare("INSERT into events (username, title, year, month, day, categorial) values (?, ?, ?, ?, ?, ?)");

if(!$to_insert){
  echo json_encode(array(
    "success" => false
  ));
  exit;
}

$to_insert->bind_param('ssiiis', $username, $event_name, $year, $month, $day,$categorial);
$to_insert->execute();
$to_insert->close();
echo json_encode(array(
    "success" => true
));
exit;

?>