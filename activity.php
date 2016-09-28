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
      $ucount[]=$row['u_count'];
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
    </head>
    <body>
       <div id="myDiv" style="width: 100%; height: 100%;"><!-- Plotly chart will be drawn inside this DIV --></div>
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
