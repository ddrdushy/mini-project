<?php
include("userclass.php");
// Parse without sections
$ini_array = parse_ini_file("configure.ini");

echo $ini_array["CAMPSITE_ID"]."\n";

$result=file_get_contents("https://api.gitter.im/v1/rooms?access_token=".$ini_array["API_KEY"]);
$object = json_decode($result);
$user_count=$object[3]->userCount;
echo $object[3]->userCount."\n";

$user_list=array();
$newuserarray=array();


  for($x=0;$x<$user_count;$x+=30){
      $result=file_get_contents("https://api.gitter.im/v1/rooms/".$ini_array["CAMPSITE_ID"]."/users?access_token=".$ini_array["API_KEY"]."&skip=".$x);
      echo $x."\n";
      $user_list[]=json_decode($result);
  }

  for($x=0;$x<count($user_list);$x++){
    echo "x: ".$x."\n";
    for($y=0;$y<count($user_list[$x]);$y++){
      echo $user_list[$x][$y]->username."\n";
      $newuserarray[]=new user($user_list[$x][$y]->id,$user_list[$x][$y]->username,$user_list[$x][$y]->avatarUrlMedium,$user_list[$x][$y]->displayName);
    }
  }

  $user_list_count=count($newuserarray);
  print_r ($newuserarray);
  //echo $newuserarray[0]->name;

?>
