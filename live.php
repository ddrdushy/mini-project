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
  //echo $object[3]->userCount."\n";

  $url_array=array();
  $user_list_new=array();
  //array for user list
     for($x=0;$x<$user_count;$x+=30){
         $url="https://api.gitter.im/v1/rooms/".$ini_array["CAMPSITE_ID"]."/users?access_token=".$ini_array["API_KEY"]."&skip=".$x;
         $url_array[]=$url;
     }

  $result=multiRequest($url_array);
  for($i=0;$i<count($result);$i++){
    $user_list_new[]=json_decode($result[$i]);
  }
//var_dump($user_list);
      for($x=0;$x<count($user_list_new);$x++){
          for($y=0;$y<count($user_list_new[$x]);$y++){
            $user_list[]=new user($user_list_new[$x][$y]->id,$user_list_new[$x][$y]->username,$user_list_new[$x][$y]->displayName);
          }
        }

    $url_list=array();
    for($i=0;$i<count($user_list);$i++)
      $url_list[]=$user_list[$i]->apiurl;


    //var_dump($url_list);
    $result = multiRequest($url_list);

    for($i=0;$i<count($user_list);$i++){
      $object=json_decode($result[$i], true);
      if(isset($object["about"]["browniePoints"]))
        $user_list[$i]->points= $object["about"]["browniePoints"];
      else
        $user_list[$i]->points= 0;
    }

    usort($user_list,"cmp");
    //var_dump($user_list);

    $total_points=0;

    for($i=0;$i<count($user_list);$i++){
      $total_points += $user_list[$i]->points;
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

    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1><span class="label label-primary">FCC Live status Viewer</span></h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6 text-center">
          <h1><span class="label label-success">Total Points : <?php echo $total_points ?></span></h1>
        </div>
        <div class="col-lg-6 text-center">
          <h1><span class="label label-success">Total Users : <?php echo $user_count ?></span></h1>
        </div>
      </div>

      <div class="row"><table class="table table-hover text-center">
        <tr>
            <th class="text-center"><h3>Rank</h3></th>
            <th class="text-center"><h3>Name</h3></th>
            <th class="text-center"><h3>points</h3></th>
            <th class="text-center"><h3>link to FCC</h3></th>
        </tr>
            <?php

            for($i=0;$i<count($user_list);$i++){
              $total_points += $user_list[$i]->points;

                  echo "<tr>
                      <td><h2>#".($i+1)."</h2></td>
                      <td><h2>".$user_list[$i]->name."</h2></td>
                      <td><h2>".$user_list[$i]->points."</h2></td>
                      <td><h2><a href=\"https://www.freecodecamp.com/".$user_list[$i]->uname."\" target=\"_blank\">".$user_list[$i]->uname."</a></h2></td>
                  </tr>";
            }
            ?>
          </table>
      </div>
    </div>
  </body>
</html>
<?php
function multiRequest($data, $options = array()) {
  // array of curl handles
  $curly = array();
  // data to be returned
  $result = array();
  // multi handle
  $mh = curl_multi_init();
  // loop through $data and create curl handles
  // then add them to the multi-handle
  foreach ($data as $id => $d) {
    $curly[$id] = curl_init();
    $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
    curl_setopt($curly[$id], CURLOPT_URL,$url);
    curl_setopt($curly[$id], CURLOPT_HEADER,0);
    curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curly[$id], CURLOPT_SSL_VERIFYPEER,false);
    // Will return the response, if false it print the response
    curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER,true);
    // post?
    if (is_array($d)) {
        if (!empty($d['post'])) {
          curl_setopt($curly[$id], CURLOPT_POST,1);
          curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
        }
    }
   // extra options?
    if (!empty($options)) {
      curl_setopt_array($curly[$id], $options);
    }
    curl_multi_add_handle($mh, $curly[$id]);
  }
  // execute the handles
  $running = null;
  $count=0;
  do {
    //echo $count++."\n";
    curl_multi_exec($mh, $running);
  } while($running > 0);

  // get content and remove handles
  foreach($curly as $id => $c) {
    $result[$id] = curl_multi_getcontent($c);
    curl_multi_remove_handle($mh, $c);
  }
  // all done
  curl_multi_close($mh);
  return $result;
}



 ?>
