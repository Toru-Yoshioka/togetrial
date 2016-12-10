<?php
$unique_key = md5(uniqid());
$lot_rand = mt_rand(0, 99);
$card_no = str_pad(mt_rand(1, 4), 2, 0, STR_PAD_LEFT);

// 抽選結果
if ($lot_rand >= 0 and $lot_rand <= 30) {
  $lot_result = 1;
} else {
  $lot_result = 0;
}
// ヒストリ登録
$conn = "host=ec2-23-23-199-72.compute-1.amazonaws.com dbname=d25481250mtets user=mtrdhlivfehdrj password=lhXZgchb6JgtNPmToWmF3yaZlh";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}
// 接続に成功
$result = pg_query('
INSERT INTO
 lottery_history
 (
  lottery_seq,
  unique_key,
  drawing_timestamp,
  drawing_result
 ) VALUES (
  nextval(\'lottery_seq\'),
  \'' . $unique_key . '\',
  current_timestamp,
  ' . $lot_result . '
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}

$close_flag = pg_close($link);

if ($close_flag){
//     print('切断に成功しました。<br>');
}
?>
<html>
  <head>
    <title>Togekichi presents Xmas Gift</title>
    <script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
    <style type="text/css">
    <!--
    body {
      background-color: #D4D9D3;
      background-position: center top;
      background-repeat: no-repeat;
      background-size: 100% auto;
      color: #ffffff;
    }
    .xmas_logo {
      text-align: center;
      margin-top: 16px;
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

      background-color:#ffffff;
    }
    //-->
    </style>
  </head>
  <body>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
    <div class="gift_box_area">
      <img src="./img/giftcard_<?php print($card_no); ?>.png"/>
    </div>
    <div id="fadeLayer"></div>
    <script type="text/javascript">
    <!--
    $("#fadeLayer").fadeOut("slow");
//    $(function(){
//      setTimeout(function(){
        // window.location.href = './lottery.php';
//      },3000);
//    });
    //-->
    </script>
    <script type="text/javascript" src="./js/snowparticle.smart.1.js"></script>
  </body>
</html>