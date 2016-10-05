<?php
$link = mysqli_connect('localhost','root','','mini');
if (!$link) {
  die('Could not connect to MySQL: ' . mysql_error());
}
$qry="SELECT * FROM `daily_count`";
$qry2=mysqli_query($link,$qry) or die (mysqli_error($link));
$pts= array();
$ucount= array();
while($row = mysqli_fetch_array($qry2, MYSQL_ASSOC)) {
      $pts[]=$row['u_date'];
      $ucount[]=$row['pts_count'];
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
          body{
            background-image:url("img/bg2.jpg");
            color: #fff;
          }
        </style>
    </head>

    <body>
        <!--navigation menu start-->
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">FCC Status Viewer</a>
            </div>
            <ul class="nav navbar-nav">
              <li><a href="#">Home</a></li>
              <li><a href="userlist.php">User List</a></li>
              <li><a href="http://fcc-status.herokuapp.com" target="_blank">Live View</a></li>
              <li><a href="userprofile.php">User Profile</a></li>
              <li><a href="userexcluder.php">User Excluder</a></li>
              <li class="active"><a href="activity.php">Activity Report</a></li>
              <li><a href="message.php">Message to Campsite</a></li>
            </ul>
          </div>
        </nav>
        <!--navigation menu end-->
       <div class="col-lg-12 text-center">
         <h1><span class="label label-lg label-success">Daily Activity Report</span></h1>
       </div>
     </br>     </br>     </br>     </br>
       <div id="myDiv"><!-- Plotly chart will be drawn inside this DIV --></div>
    </body>

    <script>
        var trace1 = {
          x: <?php echo  js_array($pts); ?>,
          y: <?php echo  js_array($ucount); ?>,
          type: 'scatter'
        };
        var data = [trace1];
        Plotly.newPlot('myDiv', data);
    </script>
</html>
