<?php
/* connect to the db */
$link = mysqli_connect("localhost", "", "", "");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//Insert data
$unSafeVar = file_get_contents('php://input');
$json = json_decode($unSafeVar, true);
$key_name = $json['key_name'];

//$id = 2464;

$mysqlCall = mysql_escape_string($key_name);

$return['sql'] = $mysqlCall;

$sqlFind = "DELETE FROM `files` WHERE `files`.`key_name`='" . $mysqlCall."'";
$found = mysqli_query($link, $sqlFind);

echo $found;
exit;
