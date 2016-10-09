<?php
  include("userclass.php");
  // Parse without sections
  $ini_array= parse_ini_file("configure.ini");
  //echo $ini_array["CAMPSITE_ID"]."\n";

  //get the user count from gitter room
  $url="https://api.gitter.im/v1/rooms?access_token=".$ini_array["API_KEY"];

  //  Initiate curl
  $ch = curl_init();
  // Disable SSL verification
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  // Will return the response, if false it print the response
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // Set the url
  curl_setopt($ch, CURLOPT_URL,$url);
  // Execute
  $result=curl_exec($ch);
  // Closing
  curl_close($ch);


  $object = json_decode($result);
  $user_count=$object[3]->userCount;
  echo $object[3]->userCount."\n";

  $url_array=array();
  $user_list_new=array();
  //array for user list
     for($x=0;$x<$user_count;$x+=30){
         $url="https://api.gitter.im/v1/rooms/".$ini_array["CAMPSITE_ID"]."/users?access_token=".$ini_array["API_KEY"]."&skip=".$x;
         $url_array[]=$url;
     }

  $result=multiRequest($url_array);

  for($i=0;$i<count($result);$i++)
      $user_list_new[]=json_decode($result[$i]);

      for($x=0;$x<count($user_list_new);$x++){
          for($y=0;$y<count($user_list_new[$x]);$y++){

          }
        }

    //sort the data based on th points
    function cmp($a, $b)
    {
        if ($a->points == $b->points) {
          return 0;
      }
      return ($a->points > $b->points) ? -1 : 1;
    }
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="node_modules\bootstrap\dist\css\bootstrap.css">
    <link rel="stylesheet" type="text/css" href="node_modules\bootstrap\dist\css\animate.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="node_modules\bootstrap\dist\js\bootstrap.js"></script>
    <style>
      body{
        background-image:url("img/bg2.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        color: #fff;
      }
      table{
        padding-top: 15px;
      }
      a:link{
        color: #bbd0f7;
      }
      a:visited{
        color: #fff;
      }
      .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
        background-color: #000;
      }
    </style>

  </head>

  <body >
    <!--navigation menu start-->
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">FCC Status Viewer</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="userlist.php">User List</a></li>
          <li class="active"><a href="live.php" target="_blank">Live View</a></li>
          <li><a href="userprofile.php">User Profile</a></li>
          <li><a href="userexcluder.php">User Excluder</a></li>
          <li><a href="activity.php">Activity Report</a></li>
          <li><a href="message.php">Message to Campsite</a></li>
        </ul>
      </div>
    </nav>
    <!--navigation menu end-->
  </body>


</html>
