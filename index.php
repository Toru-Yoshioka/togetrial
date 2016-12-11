<?php
$ck = $_COOKIE['TSID'];
if ($ck == '') {
  $conn = "host=ec2-23-23-199-72.compute-1.amazonaws.com dbname=d25481250mtets user=mtrdhlivfehdrj password=lhXZgchb6JgtNPmToWmF3yaZlh";
  $link = pg_connect($conn);
  if (!$link) {
      die('接続失敗です。'.pg_last_error());
  }
  // 接続に成功
  $setck = md5(uniqid());

$result = pg_query('
select
 count(lh1.*)
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
  lh1.drawing_timestamp < current_timestamp - interval \'5 minutes\'
  AND
   EXISTS (
    select
     *
    FROM
     togepgift
    WHERE
     created_date >= current_date - interval \'2 days\'
     AND
     published_timestamp IS NULL
   )
');

  if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
  } else {
    $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $recno = $rows['count'];
    if ($recno > 0) {
      $lottery_enable = true;
//      $debug_mes = '３分経ちました';
    } else {
      $lottery_enable = false;
//      $debug_mes = 'まだ３分経っていません';
    }
  }

// 残箱確認
  $result = pg_query('
SELECT
 count(*)
FROM
 togepgift
WHERE
 created_date >= current_date - interval \'2days\'
 AND
 published_timestamp IS NULL
  ');
  $last_cnt = 0;
  if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
  } else {
    $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $last_cnt = $rows['count'];
  }

  $close_flag = pg_close($link);

  if ($close_flag){
  //     print('切断に成功しました。<br>');
  }
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
    a:link { color: #ffffff; }
    a:visited { color: #ffffff; }
    a:hover { color: #ffffff; }
    a:active { color: #ffffff; }
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
  if ($last_cnt == 0) {
?>
    <div class="gift_box_area">
      <h1>お手伝いしてほしい箱は今は無いみたい。<br/>また、時間が経ったら来てみてね♪</h1>
    </div>
<?php
  } elseif ($lottery_enable && $ck == '') {
?>
    <div class="gift_box_area">
      <a href="javascript:fade();">
        <img src="./img/giftbox_off.png"/>
      </a>
      <h1>ギフトボックスをタップしてネ♪</h1>
    </div>
<?php
  } else {
?>
    <div class="gift_box_area">
      <img src="./img/santa.png"/>
      <h1>次のプレゼントを用意してるみたいだよ...<br/><a href="/">もう準備できた？</a></h1>
    </div>
<?php
  }
?>
    <div id="fadeLayer"></div>
    <p>
    </p>
  </body>
</html>
