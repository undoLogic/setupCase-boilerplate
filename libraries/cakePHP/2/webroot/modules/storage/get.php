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

$mysqlCall = mysql_escape_string($key_name);

$return['sql'] = $mysqlCall;


$sqlFind = "SELECT id, key_name, mime, data, created FROM files WHERE current='1' AND key_name='" . $mysqlCall."';";

//echo $sqlFind;exit;

$found = mysqli_query($link, $sqlFind);

$return = array();
$found_key_name = '';
$found_data = '';
$found_mime = '';
$found_verify = '';

if (mysqli_num_rows($found) > 0) {

    while ($row = mysqli_fetch_array($found)) {
        $found_key_name = $row['key_name'];
        $found_data = base64_encode($row['data']);
        $found_verify = md5($row['data']);
        $found_mime = $row['mime'];
        //base64_encode($row['data'])
        //echo "<img src='data:image/png;base64," . base64_encode($row['data']) . "'/>";
    }

    $return['status'] = 200;
    $return['status_msg'] = "Found #".$found_key_name;

    $return['data_verify'] = $found_verify;
    $return['data'] = $found_data;
    $return['mime'] = $found_mime;

} else {
    $return['status'] = 404;
    $return['status_msg'] = "Nothing found in the database for the ".$id;
}

// Close connection
mysqli_close($link);


echo json_encode($return);

exit;