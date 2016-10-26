<?php
    $uid=$_GET["uid"];
    $link = mysqli_connect('localhost','root','','mini');
    if (!$link) {
      die('Could not connect to MySQL: ' . mysql_error());
    }
    $qry="select `user`.`name`,`user`.`uname`,`user`.`url`,`user`.`doj`,`daily_update`.`points` from `user`,`daily_update` where `user`.`uid`='".$uid."' and `daily_update`.`uid`='".$uid."' and `daily_update`.`r_date`='".date("Y-m-d")."'";
    $res=mysqli_query($link,$qry) or die (mysqli_error($link));
    while($row = mysqli_fetch_array($res, MYSQL_ASSOC)) {
      $name=$row["name"];
      $uname=$row["uname"];
      $url=$row["url"];
      $points=$row["points"];
      $doj=$row["doj"];
    }
    $qry="select `daily_update`.`points` from `daily_update` where `daily_update`.`uid`='".$uid."' and `daily_update`.`r_date`='".date('Y-m-d',strtotime("-1 days"))."'";
    $res=mysqli_query($link,$qry) or die (mysqli_error($link));
    $oldpts="";
    while($row = mysqli_fetch_array($res, MYSQL_ASSOC)) {
      $oldpts=$row["points"];
    }
    if($oldpts==null or !$oldpts)
      $rank_old=0;
    if($oldpts<$points)
      $glyphi="img/up.png";
    else
      $glyphi="img/equal.png";


      $qry="SELECT `points`,`r_date` FROM `daily_update` where `uid`='".$uid."'";
      $qry2=mysqli_query($link,$qry) or die (mysqli_error($link));
      $pts= array();
      $rdate= array();
      while($row = mysqli_fetch_array($qry2, MYSQL_ASSOC)) {
            $rdate[]=$row['r_date'];
            $pts[]=$row['points'];
      }


      function js_str($s)
      {
          return '"' . addcslashes($s, "\0..\37\"\\") . '"';
      }

      function js_array($array)
      {
          $temp = array_map('js_str', $array);
          return '[' . implode(',', $temp) . ']';
      }




?>
<html>
    <head>
      <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
      <link rel="stylesheet" type="text/css" href="node_modules\bootstrap\dist\css\bootstrap.css">
      <link rel="stylesheet" type="text/css" href="node_modules\bootstrap\dist\css\animate.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="node_modules\bootstrap\dist\js\bootstrap.js"></script>
      <style>
        .img{
          position:absolute;
        }
        h2,h3{
          padding-left: 85px;
          padding-top: -5px;
        }
        .img{
          padding-top: 30px;
        }
        body{
          background-image:url("img/bg2.jpg");
          color: #fff;
          background-repeat: no-repeat;
          background-attachment: fixed;
        }
        a:link{
          color: #fff;
        }
        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
          background-color: #000;
        }
        .tab{
          padding-top: 50px;
        }
        td{
          font-size: 35px;
        }
      </style>
    </head>

    <body>
      <!--navigation menu start-->
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="index.php">FCC Status Viewer</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="userlist.php">User List</a></li>
            <li><a href="http://fcc-status.herokuapp.com" target="_blank">Live View</a></li>
            <li class="active"><a href="userprofile.php">User Profile</a></li>
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
            <h1><span class="label label-lg label-primary col-lg-12"><?php echo $name ?></span></h1>
          </div>
        </div>
        <br /><br />
        <div class="row">
          <div class="col-lg-5">
            <img src="<?php echo $url ?>" class="img-thumbnail" width="450px" height="450px"/>
          </div>
          <div class="col-lg-7 tab">
            <table class="table table-hover">
              <tr>
                <td>
                  User Name:
                </td>
                <td>
                  <?php echo $uname ?>
                </td>
              </tr>
              <tr>
                <td>
                  Points:
                </td>
                <td>
                  <?php echo $points."\t\t"?><img src="<?php echo $glyphi ?>" width="50px" height="50px"/>
                </td>
              </tr>
              <tr>
                <td>
                  Date of Join:
                </td>
                <td>
                  <?php echo $doj ?>
                </td>
              </tr>
              <tr>
                <td>
                  FCC Link:
                </td>
                <td>
                  <a href="<?php echo "https://www.freecodecamp.com/".$uname ?>" target="_blank"><?php echo $uname?></a>
                </td>
              </tr>
              <tr>
                <td>
                  Gitter Link:
                </td>
                <td>
                  <a href="<?php echo "https://www.gitter.im/".$uname ?>" target="_blank"><?php echo $uname?></a>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <h1><span class="label label-lg label-info col-lg-12"><?php echo $name."'s Activity Graph" ?></span></h1>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div id="myDiv">
            </div>
          </div>
        </div>
      </div>
    </body>
    <script>
        var trace1 = {
          x: <?php echo  js_array($rdate); ?>,
          y: <?php echo  js_array($pts); ?>,
          type: 'scatter',
          mode: 'lines+markers'
        };
        var data = [trace1];

        var layout = {
                    xaxis: {
                      title: 'Time'
                    },
                    yaxis: {
                      title: 'Points'
                    }
                  }
        Plotly.newPlot('myDiv', data,layout);
    </script>
</html>
