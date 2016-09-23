<?php
// Parse without sections
$ini_array = parse_ini_file("configure.ini");
echo $ini_array["CAMPSITE_ID"]."\n";

$result=file_get_contents("https://api.gitter.im/v1/rooms?access_token=".$ini_array["API_KEY"]);
$object = json_decode($result);
$user_count=$object[3]->userCount;
echo $object[3]->userCount."\n";

$user_list=array();

  for($x=0;$x<$user_count;$x+=30){
      $result=file_get_contents("https://api.gitter.im/v1/rooms/".$ini_array["CAMPSITE_ID"]."/users?access_token=".$ini_array["API_KEY"]."&skip=".$x);
      echo $x."\n";
      $user_list[]=json_decode($result);
  }

  $user_list_count=count($user_list[0]);

  echo $user_list_count;

?>
