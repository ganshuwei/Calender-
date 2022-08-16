<?php
// login_ajax.php

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);


//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$month = $json_obj['month'];
$year = $json_obj['year'];
$day=$json_obj['day'];
$username = $json_obj['username'];

// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)

require 'database.php';

$stmt = $mysqli->prepare("SELECT event_id, title, categorial, if_finished FROM events WHERE day= ? and month = ? and year = ? and username = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$ids = array();
$names = array();
$categorials = array();
$indexs=array();


$stmt->bind_param('iiis', $day, $month, $year, $username);
$stmt->execute();
$stmt->bind_result($id, $name, $categorial,$index);

while($stmt->fetch()) {
    $ids[] = htmlentities($id); //these htmlentities are prevention for xss attacks
    $names[] = htmlentities($name);
    $categorials[] = htmlentities($categorial);
    $indexs[]=htmlentities($index);
}

$stmt->close();

if (count($ids) < 1){
	echo json_encode(array(
		"success" => false
	));
	exit;
}

else {
    
	echo json_encode(array(
		"success" => true,
        "names" => $names,
        "ids" => $ids,
        "categorials" => $categorials,
        "indexs" => $indexs
	));
	exit;
}

?>