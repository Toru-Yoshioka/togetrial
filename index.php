<?php
$conn = "host=ec2-23-23-199-72.compute-1.amazonaws.com dbname=d25481250mtets user=mtrdhlivfehdrj password=lhXZgchb6JgtNPmToWmF3yaZlh";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}
// 接続に成功
$setck = md5(uniqid());

$result = pg_query('
select
 count(lh1.*) AS RESULT_CNT
FROM
 lottery_history lh1,
 (
  select
   lottery_seq,
   drawing_timestamp
  FROM
   lottery_history lh2
  WHERE
   lh2.drawing_result = 1
  ORDER BY
   lh2.drawing_timestamp DESC
  LIMIT 1
 ) lh3
WHERE
  lh1.lottery_seq = lh3.lottery_seq
  AND
  lh1.drawing_timestamp < current_timestamp - interval \'3 minutes\'
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
} else {
  $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
  $recno = $rows['RESULT_CNT'];
  if ($recno > 0) {
    $lottery_enable = true;
    $debug_mes = '３分経ちました';
  } else {
    $lottery_enable = false;
    $debug_mes = 'まだ３分経っていません';
  }
//  for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
//      $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
//      print('CODE:<br/>');
//      print($rows['code']);
//      print('<br/>');
//      print('CREATED:<br/>');
//      print($rows['createddate']);
//      print('<br/>');
//      print('PUBLISHED:<br/>');
//      print($rows['published']);
//      print('<br/>');
//  }
}

$close_flag = pg_close($link);

if ($close_flag){
//     print('切断に成功しました。<br>');
}
?>
<html>
  <head>
    <title>Togekichi presents Xmas Advent Gift</title>
    <script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
    <style type="text/css">
    <!--
    body {
      background-color: #650000;
      background-image: url('./img/bg_xmas_top.png');
      background-position: center top;
      background-repeat: no-repeat;
      background-size: 100% auto;
      color: #ffffff;
    }
    .xmas_logo {
      text-align: center;
      margin-top: 64px;
    }
    .gift_box_area {
      text-align: center;
    }
    .gift_box_area img {
      padding-left: 2%;
      padding-right: 2%;
    }
    #fadeLayer {
      position:absolute;
      top:0px;
      left:0px;

      width:100%;
      height:100%;

      background-color:#FFFFFF;
      opacity: 1.0;
      display: none;
      z-index:1;
    }
    //-->
    </style>
    <script type="text/javascript">
    <!--
    function fade() {
      $("#fadeLayer").fadeIn("slow");
      $(function(){
        setTimeout(function(){
          window.location.href = './lottery.php';
        },3000);
      });
    }
    //-->
    </script>
  </head>
  <body>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
<?php
  if ($lottery_enable) {
?>
    <h3><?php print($debug_mes); ?></h3>
    <div class="gift_box_area">
      <a href="javascript:fade();">
        <img src="./img/giftbox_off.png"/>
      </a>
    </div>
<?php
  } else {
?>
    <h3><?php print($debug_mes); ?></h3>
<?php
  }
?>
    <div id="fadeLayer"></div>
    <p>
    </p>
  </body>
</html>
