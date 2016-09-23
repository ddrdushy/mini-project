<?php
// Parse without sections
$ini_array = parse_ini_file("configure.ini");
echo $ini_array["CAMPSITE_ID"]."\n";

$result=file_get_contents("https://api.gitter.im/v1/rooms?access_token=".$ini_array["API_KEY"]);
$object = json_decode($result);
$user_count=$object[3]->userCount;
echo $object[3]->userCount;

?>
