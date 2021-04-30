<?php
/* connect to the db */
$link = mysqli_connect("localhost", "", "", "");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//Insert data
$unSafeVar = file_get_contents('php://input');
$json = json_decode($unSafeVar, true);

$data = base64_decode($json['data']);
$data_md5 = $json['md5'];
$mime = $json['mime'];
$key_name = $json['key_name'];
$domain = $json['domain'];
$reference = $json['reference'];


$insertData = mysql_escape_string($data);

$verify_here = md5($data);

$insertJson = "md5: ".$data_md5." calculated here:".md5($data);

$return = array();

$return['insert_msg'] = $insertJson;

$sql = "INSERT INTO `files` (`id`, `domain`, `key_name`, `mime`, `data`, `verify`, `reference`, `created`) VALUES (NULL, '".$domain."', '".$key_name."', '".$mime."', '".$insertData."', '".$verify_here."', '".$reference."', '".date('Y-m-d H:i:s')."'); ";

if(mysqli_query($link, $sql)){
    $lastInsertID = $link->insert_id;

    $sqlCurrent = "UPDATE `files` SET `current`='0' WHERE `key_name` = '".$key_name."';";
    mysqli_query($link, $sqlCurrent);

    $sqlCurrent = "UPDATE `files` SET `current`='1' WHERE `id` = '".$lastInsertID."';";
    mysqli_query($link, $sqlCurrent);



    $return['status'] = 200;
    $return['status_msg'] = "Saved";
    $return['id'] = $lastInsertID;

    $sqlFind = "SELECT id, key_name, mime, data, created FROM files WHERE id=".$lastInsertID;
    $found = mysqli_query($link, $sqlFind);

    if (mysqli_num_rows($found) > 0) {
        while ($row = mysqli_fetch_array($found)) {
            $verify_id = $row['id'];
            $data = $row['data'];
        }
        $return['verify_status'] = 200;
        $return['verify_id'] = $verify_id;
        $return['verify'] = md5($data);
    }
    else {
        $return['verify_status'] = 404;
    }

} else{
    $return['status'] = 500;
    $return['status_msg'] = "Cannot save to DB ".mysqli_error($link);

}
// Close connection
mysqli_close($link);

echo json_encode($return);

exit;