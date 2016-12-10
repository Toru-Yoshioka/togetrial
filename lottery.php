<?php
$ck = $_COOKIE['TSID'];
$rf = $_SERVER['HTTP_REFERER'];
if ($ck == '' and $rf == 'https://togetrial.herokuapp.com/') {
  $unique_key = md5(uniqid());
  setcookie('TSID', $unique_key, time()+30);
} else {
  header('Location: /');
  exit;
}
$lot_rand = mt_rand(0, 99);
$card_no = str_pad(mt_rand(1, 4), 2, 0, STR_PAD_LEFT);

// 抽選結果
if ($lot_rand >= 0 and $lot_rand <= 25) {
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

// 当選時
if ($lot_result > 0) {
// ギフト情報取得
  $result = pg_query('
SELECT
 code,
 packet_size,
 created_date + interval \'2 days 23 hours 59 minutes 59 seconds\' AS limit_date
FROM
 togepgift
WHERE
 created_date >= current_date - interval \'2days\'
 AND
 published_timestamp IS NULL
ORDER BY
 created_date DESC
LIMIT 1
  ');
  if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
  } else {
    $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $gift_code = $rows['code'];
    $packet_size = $rows['packet_size'];
    $limit_date = $rows['limit_date'];
  }
// 発行済み処理
  $result = pg_query('
UPDATE
 togepgift
SET
 published_timestamp = current_timestamp,
 unique_key = \'' . $unique_key . '\'
WHERE
 code = \'' . $gift_code . '\'
  ');
  if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
  }
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
      color: #aa0000;
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
    .gift_info {
      position: absolute;
      bottom: 128px;
      left: 35%;
      font-size: 48pt;
      background: rgba(0,0,0,.6);
      color: #ffffff;
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
<?php
  if ($lot_result > 0) {
?>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
    <div class="gift_box_area">
      <h1>ギフトコード</h1>
      <figure style="position: relative;">
        <img src="./img/giftcard_<?php print($card_no); ?>.png"/>
        <figcaption class="gift_info">
          <?php print($gift_code); ?>
        </figcaption>
      </figure>
      <h2>パケット容量: <?php print($packet_size); ?> MB</h2>
      <h2>有効期限: <?php print($limit_date); ?></h2>
      <br/>
      <h1>おめでとう！</h1>
      <h1><a target="_blank" href="https://my.mineo.jp/">mineo マイページ</a> から受け取ってネ♪</h1>
      <br/>
      <h1><a href="/">サンタの部屋にもどる</a></h1>
    </div>
<?php
  } else {
?>
    <div class="gift_box_area" style="margin-top: 10%;">
      <img src="./img/giftbox_empty.png"/>
      <h1>あれ･･･？ 空箱だったみたい(^_^;</h1>
      <h1>サンタさんがすぐに<br/>次のプレゼントを用意してるみたいだよ。</h1>
      <h1><a href="/">もう１度チャレンジする</a></h1>
    </div>
<?php
  }
?>
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
