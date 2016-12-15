<?php
date_default_timezone_set('Asia/Tokyo');
$conn = "host=ec2-23-23-199-72.compute-1.amazonaws.com dbname=d25481250mtets user=mtrdhlivfehdrj password=lhXZgchb6JgtNPmToWmF3yaZlh";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}

// はずれ抽選
$lose_no = mt_rand(1, 11);

// 接続に成功
$result = pg_query('
SELECT
 item_seq,
 item_name,
 item_image_file,
 item_description
FROM
 unsuccessful_items
WHERE
 item_seq = ' . $lose_no . '
');

if (!$result) {
  die('クエリーが失敗しました。'.pg_last_error());
} else {
  $rows_cnt = pg_num_rows($result);
}

if ($rows_cnt > 0) {
  $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
  $item_name = '『' . $rows['item_name'] . '』 がでてきました！';
  $item_image_file = $rows['item_image_file'];
  $item_description = $rows['item_description'];
} else {
  $item_name = 'からっぽでした・・・';
  $item_image_file = 'empty.png';
  $item_description = '箱の中には何もはいっていませんでした。<br/>うっかり子供たちに届けられては大変です！<br/>あざらしサンタが片づけておきます。';
}

$close_flag = pg_close($link);

if ($close_flag){
//     print('切断に成功しました。<br>');
}
?>
<html>
  <head>
    <meta name="viewpoint" content="target-densitydpi=device-dpi, width=device-width, maximum-scale=1.0, user-scalable=yes"/>
    <title>Togekichi presents Xmas Gift</title>
    <script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
    <style type="text/css">
    <!--
    body {
      background-color: #03265d;
      background-image: url('./img/bg_xmas_lottery.png');
      background-position: center top;
      background-repeat: no-repeat;
      background-size: 100% auto;
      color: #ffffff;
      font-weight: bold;
      -webkit-text-size-adjust: 100%;
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
    .open_box {
      position: absolute;
      bottom: 32px;
      left: 48px;
    }
    .item_description {
      background: rgba(0,0,0,.6);
    }
    #fadeLayer {
      position:absolute;
      top:0px;
      left:0px;

      width:100%;
      height:100%;

      background-color:#ffffff;
    }
    a:hover { color: #ffffff; }
    a:visited { color: #ffffff; }
    a:link { color: #ffffff; }
    a:active { color: #ffffff; }
    //-->
    </style>
  </head>
  <body>
<?php
  $lot_result = $_GET['r'];
  if ($lot_result > 0) {
    $card_no = str_pad(mt_rand(1, 4), 2, 0, STR_PAD_LEFT);
?>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
    <div class="gift_box_area">
      <h1>『ギフトコード』 がでてきました！</h1>
      <figure style="position: relative;">
        <img src="./img/giftcard_<?php print($card_no); ?>.png"/>
        <figcaption class="gift_info">
          ABCD1234
        </figcaption>
        <img class="open_box" src="./img/giftbox_empty_mini.png"/>
      </figure>
      <h2>パケット容量: 50 MB</h2>
      <h2>有効期限: 2016/12/15 23:59:59</h2>
      <br/>
      <h1>おめでとう！</h1>
      <h1><a target="_blank" href="https://my.mineo.jp/">mineo マイページ</a> から受け取ってネ♪</h1>
      <br/>
      <h1><a href="/">サンタの部屋にもどる</a></h1>
    </div>
<?php
  } else {
?>
    <div class="xmas_logo"><img src="./img/logo_xmas_silver.png"/></div>
    <div class="gift_box_area">
      <h1><?php print($item_name); ?></h1>
      <figure style="position: relative;">
        <img src="./img/<?php print($item_image_file); ?>"/>
        <img class="open_box" src="./img/giftbox_empty_mini.png"/>
      </figure>
      <h1 class="item_description"><?php print($item_description); ?></h1>
      <br/>
      <h2>サンタさんがすぐに<br/>次のプレゼントを用意してるみたいだよ。</h2>
      <br/>
      <h1><a href="/">もう１度チャレンジする</a></h1>
    </div>
<?php
  }
?>
    <div id="fadeLayer"></div>
    <script type="text/javascript">
    <!--
    $("#fadeLayer").fadeOut("slow");
    </script>
    <script type="text/javascript" src="./js/snowparticle.smart.1.js"></script>
  </body>
</html>
