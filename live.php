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
