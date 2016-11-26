<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <?php echo '<p>Hello World</p>'; ?> 
    <h3>postgreSQL query result</h3>
    <p>
<?php
$conn = "host=ec2-23-23-199-72.compute-1.amazonaws.com dbname=d25481250mtets user=mtrdhlivfehdrj password=lhXZgchb6JgtNPmToWmF3yaZlh";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}

print('接続に成功しました。<br>');

$result = pg_query('SELECT * FROM togegift');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}

$close_flag = pg_close($link);

if ($close_flag){
    print('切断に成功しました。<br>');
}
?>
    </p>
  </body>
</html>
