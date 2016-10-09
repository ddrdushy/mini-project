<?php
//SELECT `user`.`name`,`user`.`url`,`daily_update`.`points`,`daily_update`.`rank` FROM `daily_update`,`user` WHERE `user`.`uid`=`daily_update`.`uid` and `daily_update`.`r_date`='2016-09-25'
$link = mysqli_connect('localhost','root','','mini');
if (!$link) {
  die('Could not connect to MySQL: ' . mysql_error());
}
$qry="SELECT `user`.`uid`,`user`.`name`,`user`.`uname`,`user`.`url`,`daily_update`.`points`,`daily_update`.`rank` FROM `daily_update`,`user` WHERE `user`.`uid`=`daily_update`.`uid` and `daily_update`.`r_date`='".date('Y-m-d')."' ORDER BY `daily_update`.`points` DESC";
$qry2=mysqli_query($link,$qry) or die (mysqli_error($link));
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
          <li class="active"><a href="userlist.php">User List</a></li>
          <li><a href="http://fcc-status.herokuapp.com" target="_blank">Live View</a></li>
          <li><a href="userprofile.php">User Profile</a></li>
          <li><a href="userexcluder.php">User Excluder</a></li>
          <li><a href="activity.php">Activity Report</a></li>
          <li><a href="message.php">Message to Campsite</a></li>
        </ul>
      </div>
    </nav>
    <!--navigation menu end-->


    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h1><span class="label label-primary col-lg-12">User List</span></h1>
          </div>
        </div>
    </div>
    <br/>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 ">
          <table class="table table-hover text-center">
            <tr>
                <th class="text-center"><h3>Rank</h3></th>
                <th colspan="2" class="text-center"><h3>Name</h3></th>
                <th class="text-center"><h3>points</h3></th>
                <th class="text-center" colspan="2"><h3>link to FCC</h3></th>
            </tr>
                <?php
                while($row = mysqli_fetch_array($qry2, MYSQL_ASSOC)) {
                      $name=$row['name'];
                      $url=$row['url'];
                      $points=$row['points'];
                      $rank=$row['rank'];
                      $uname=$row['uname'];
                      $uid=$row['uid'];

                      $qry3="SELECT `points` FROM `daily_update` WHERE `uid`='".$uid."' and `r_date`='".date('Y-m-d',strtotime("-1 days"))."'";
                      $qry4=mysqli_query($link,$qry3) or die (mysqli_error($link));
                      while($row2 = mysqli_fetch_array($qry4, MYSQL_ASSOC)) {
                        $rank_old= $row2['points'];
                      }
                      if($rank_old==null or !$rank_old)
                        $rank_old=0;

                      if($points>$rank_old)
                        $img="img/up.png";
                      else if($points<$rank_old)
                        $img="img/down.png";
                      else
                        $img="img/equal.png";

                      echo "<tr>
                          <td><h2>#".$rank."</h2></td>
                          <td><img src=\"".$url."\" width=\"75px\" height=\"75px\"/></td>
                          <td><h2>".$name."</h2></td>
                          <td><h2>".$points."</h2></td>
                          <td><img src=\"".$img."\" width=\"75px\" height=\"75px\"/></td>
                          <td><h2><a href=\"https://www.freecodecamp.com/".$uname."\" target=\"_blank\">".$uname."</a></h2></td>
                      </tr>";
                }
                ?>
          </table>
        </div>
      </div>
    </div>

</body>
