<html>
  <head>
    <title>PHP Test</title>
    <style type="text/css">
    <!--
    body {
      background-color: #650000;
      background-image: url('./img/bg_xmas_top.png');
      background-position: center top;
      background-repeat: no-repeat;
      background-size: 100% auto;
    }
    .xmas_logo {
      text-align: center;
      margin-top: 64px;
    }
    .gift_box_area {
      text-align: center;
      padding-left: 5%;
      padding-right: 5%;
    }
    .gift_box_area img {
      padding-left: 2%;
      padding-right: 2%;
    }
    //-->
    </style>
  </head>
  <body>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
    <div class="gift_box_area">
      <a href="javascript:void(0);">
        <img src="./img/giftbox.png"/>
      </a>
      <a href="javascript:void(0);">
        <img src="./img/giftbox.png"/>
      </a>
      <a href="javascript:void(0);">
        <img src="./img/giftbox.png"/>
      </a>
    </div>
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
