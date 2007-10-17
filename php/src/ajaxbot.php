<?php 
 
parse_str( file_get_contents("php://input"), $_POST);

// Here we call JSON.php
require_once("JSON.php");

include "respond.php";

	// Start the session or get the existing session.
	session_start();
	$myuniqueid=session_id();

	// Here is where we get the reply.
	$botresponse=replybotname($HTTP_POST_VARS['input'],$myuniqueid,"TestBot");

// Then we do the query to the MySQL DB, and fetch the results  
//$conector = mysql_connect('127.0.0.1', 'root', 'juan') or die(mysql_error());
//mysql_select_db('JSONPHP') or die(mysql_error());  

//$sqlQuery = "SELECT * FROM directory WHERE name LIKE '". $_REQUEST['tosearch']. "%'";
//$dataReturned = mysql_query($sqlQuery) or die(mysql_error());
$i = 0;
//while($row = mysql_fetch_array($dataReturned)){ 
    // We fill the $value array with the data.
//    $value{"item"}{$i}{"response"}= $botresponse->response;
//    $value{"item"}{$i}{"session_name"}= session_name();
//    $value{"item"}{$i}{"session_uid"}= $uid;
    $value{"response"}= $botresponse->response;
    $value{"session_name"}= session_name();
    $value{"session_uid"}= $uid;

//}
// We use JSON.php for convert the data to JSON format and send it to the browser  
$json = new Services_JSON();
$output = $json->encode($value);
print($output);
?>
