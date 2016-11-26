<html>
  <head>
    <title>PHP Test</title>
    <style type="css/test">
    <!--
    .body { background-color: #00A23F; }
    //-->
    </style>
  </head>
  <body>
    <?php echo '<p>Hello World</p>'; ?>
    <h3>ギフトボックス</h3>
    <img src="./giftbox.png"/>
    <h3>postgreSQL query result</h3>
    <p>
<?php
$conn = "host=ec2-23-23-199-72.compute-1.amazonaws.com dbname=d25481250mtets user=mtrdhlivfehdrj password=lhXZgchb6JgtNPmToWmF3yaZlh";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}

print('接続に成功しました。<br>');

$result = pg_query('SELECT * FROM togepgift');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
} else {
  for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
      $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
      print('CODE:<br/>');
      print($rows['code']);
      print('<br/>');
      print('CREATED:<br/>');
      print($rows['createddate']);
      print('<br/>');
      print('PUBLISHED:<br/>');
      print($rows['published']);
      print('<br/>');
  }
}

$close_flag = pg_close($link);

if ($close_flag){
    print('切断に成功しました。<br>');
}
?>
    </p>
  </body>
</html>
