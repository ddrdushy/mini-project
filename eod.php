<?php
include("userclass.php");
// Parse without sections
$ini_array = parse_ini_file("configure.ini");
//echo $ini_array["CAMPSITE_ID"]."\n";

  //get the user count from gitter room
  $result=file_get_contents("https://api.gitter.im/v1/rooms?access_token=".$ini_array["API_KEY"]);
  $object = json_decode($result);
  $user_count=$object[3]->userCount;
  echo $object[3]->userCount."\n";
  //got the user count in $user_count variable

  //get the user count from table
  $link = mysqli_connect('localhost','root','','mini');
  if (!$link) {
    die('Could not connect to MySQL: ' . mysql_error());
  }
  $qry="SELECT count(*) FROM `user`";
  $res=mysqli_query($link,$qry) or die (mysqli_error($link));
  while($row = mysqli_fetch_array($res, MYSQL_ASSOC)) {
      $dbcount=$row["count(*)"];
   }
  print_r($dbcount);

  if($user_count!=$dbcount){
    userUpdate();
  }
//user updation in table is finished

//select the users from user table and add them to the user class
  $qry="SELECT * FROM `user` WHERE `excluder`='N'";
  $res=mysqli_query($link,$qry) or die (mysqli_error($link));
  //array for user list
  $user_list=array();

  //insert the fetched data to the array
  while($row = mysqli_fetch_array($res, MYSQL_ASSOC)) {
    $user_list[]=new user($row["uid"],$row["uname"],$row["name"]);
   }

   //print_r($user_list);
   //data inserted

   //sort the data based on th points

   function cmp($a, $b)
   {
       if ($a->points == $b->points) {
         return 0;
     }
     return ($a->points > $b->points) ? -1 : 1;
   }

   usort($user_list,"cmp");
   print_r($user_list);

/*

$newuserarray=array();



$qry="SELECT * FROM `user` WHERE `excluder`='N' ";



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

  //echo $newuserarray[0]->name;
  function cmp($a, $b)
  {
      if ($a->points == $b->points) {
        return 0;
    }
    return ($a->points > $b->points) ? -1 : 1;
  }

  usort($newuserarray,"cmp");
  //print_r($newuserarray);
  echo "\n".$newuserarray[0]->points;


  for($a=0;$a<count($newuserarray);$a++){
  //  $qry="INSERT INTO `user`(`uid`, `name`, `doj`, `uname`, `url`) VALUES ('".$newuserarray[$a]->id."','".$newuserarray[$a]->name."','". date("Y-m-d") ."','".$newuserarray[$a]->uname."','".$newuserarray[$a]->img."')";
    //$res=mysqli_query($link,$qry) or die (mysqli_error($link));

    echo $res;
  }

*/

?>
