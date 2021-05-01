<?php

include('shared.php');

$config = json_decode(file_get_contents('config.json'), true);
$host = $_SERVER['HTTP_HOST'];

/* connect to the db */
$link = mysqli_connect($config[ $host ]['host'], $config[$host]['username'], $config[$host]['password'], $config[$host]['database']);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//Insert data
$unSafeVar = file_get_contents('php://input');
$json = json_decode($unSafeVar, true);
if ($config['security'] !== $json['security']) {
	$msg = 'Security does NOT match';
	writeToLog('debug', 'Security NOT allowed');
	die('400: Not allowed');
} else {
	writeToLog('debug', 'Security allowed');
}
$key_name = $json['key_name'];

$mysqlCall = mysqli_real_escape_string($link, $key_name);

$return['sql'] = $mysqlCall;

$sqlFind = "DELETE FROM `files` WHERE `files`.`key_name`='" . $mysqlCall."'";
$found = mysqli_query($link, $sqlFind);

echo $found;
exit;
