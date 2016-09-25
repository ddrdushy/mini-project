<?php
$link = mysqli_connect('localhost','root','','mini');
if (!$link) {
  die('Could not connect to MySQL: ' . mysql_error());
}
 ?>


<html>
  <head>
    <link rel="stylesheet" type="text/css" href="node_modules\bootstrap\dist\css\bootstrap.css">
    <link rel="stylesheet" type="text/css" href="node_modules\bootstrap\dist\css\animate.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="node_modules\bootstrap\dist\js\bootstrap.js"></script>
    <style>
      h2{
        font-size: 150px;
      }
      h1{
        font-size: 50px;
      }
      h3{
        font-size: 75px;
        font-weight: bold;
        font-style: italic;
      }
      h4{
        font-size: 50px;
        font-style: italic;
      }
      .count{
        padding: 100px 0px 0px 300px;
      }
      .cont{
        padding-top: 100px;
      }
      #myCarousel{
        height:500px;
      }
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
          <li class="active"><a href="#">Home</a></li>
          <li><a href="userlist.php">User List</a></li>
          <li><a href="#">Live View</a></li>
          <li><a href="#">Activity Report</a></li>
        </ul>
      </div>
    </nav>
    <!--navigation menu end-->

    <!--carousel start -->
    <div class="container-fluid">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <!--
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
      </ol>
      -->
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
      <?php
      $qry="SELECT * FROM `daily_count`";
      $qry2=mysqli_query($link,$qry) or die (mysqli_error($link));
      while($row = mysqli_fetch_array($qry2, MYSQL_ASSOC)) {
            $pts=$row['pts_count'];
            $ucount=$row['u_count'];
      }
          echo "<div class=\"item active\">
                    <div class=\"cont\">
                    <div class=\"row\">
                        <div class=\"col-lg-12 text-center\">
                          <h1>Total Problems:".$pts." </h1>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-lg-12 text-center\">
                          <h1>Total Problems:".$ucount." </h1>
                        </div>
                    </div>
                    </div>
                </div>";

      $qry="SELECT `user`.`name`,`user`.`url`,`daily_update`.`points` FROM `daily_update`,`user` WHERE `user`.`uid`=`daily_update`.`uid` and `daily_update`.`r_date`='2016-09-25' limit 3";
      $qry2=mysqli_query($link,$qry) or die (mysqli_error($link));
      $count=0;
       while($row = mysqli_fetch_array($qry2, MYSQL_ASSOC)) {
             $count++;
             $name=$row['name'];
             $url=$row['url'];
             $points=$row['points'];
             echo "<div class=\"item\">
             <h1 class=\"col-lg-12 text-center\"><span class=\"label label-primary\">Maximum Problem Solver</span></h1>
                 <div class=\"row\">
                     <div class=\"col-lg-6 count\">
                       <h2>#".$count."</h2>
                     </div>
                     <div class=\"col-lg-6\">
                       <div class=\"cont\">
                         <h3>".$name."</h3>
                         <h4>".$points."</h4>
                         <img src=\"".$url."\"></img>
                      </div>
                     </div>
                 </div>
               </div>\n";
         }
      ?>
        </div>
      </div>
<!--
        <div class="item">
          <div class="row">
              <div class="col-lg-6">
                <img src="http://rootear.com/files/2014/09/logo-prin-java.jpg"></img>
              </div>
              <div class="col-lg-6">
                <h1><span class="label label-info">Maximum Problem Solver</span></h1>
                <h2>#2</h2>
              </div>
          </div>
        </div>

        <div class="item">
          <div class="row">
              <div class="col-lg-6">
                <img src="http://rootear.com/files/2014/09/logo-prin-java.jpg"></img>
              </div>
              <div class="col-lg-6">
                <h1><span class="label label-success">Maximum Problem Solver</span></h1>
                <h2>#3</h2>
              </div>
          </div>
        </div>
-->


      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
        </div>
          </div>
    <!--carousel end -->

  </body>
</html>
