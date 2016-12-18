<html>
  <head>
    <meta name="viewpoint" content="target-densitydpi=device-dpi, width=device-width, maximum-scale=1.0, user-scalable=yes"/>
    <title>Togekichi presents Xmas Gift</title>
    <script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">
    <!--
      var tguid = localStorage.getItem('TGUID');
      if (tguid != null && tguid != '') {
        $.cookie('TGUID', tguid);
      }
    //-->
    </script>
<?php
date_default_timezone_set('Asia/Tokyo');

$rf = $_SERVER['HTTP_REFERER'];
if (isset($_COOKIE['TGUID']) and $rf == 'https://togetrial.herokuapp.com/') {
  $tguid = $_COOKIE['TGUID'];
} else {
  header('Location: /');
  exit;
}

// はずれNo
if (isset($_GET['no'])) {
  $lose_no = $_GET['no'];
} else {
  header('Location: /');
  exit;
}

$conn = "host=ec2-23-23-199-72.compute-1.amazonaws.com dbname=d25481250mtets user=mtrdhlivfehdrj password=lhXZgchb6JgtNPmToWmF3yaZlh";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}

// 接続に成功
$result = pg_query('
SELECT
 item_seq,
 item_name,
 item_image_file,
 item_description
 uij.unique_key
FROM
 unsuccessful_items ui LEFT OUTER JOIN
 uniquekey_item_join uij
 ON ui.item_seq = uij.item_seq AND uij.unique_key = \'' . $tguid . '\'
WHERE
 ui.item_seq = ' . $lose_no . '
ORDER BY
 ui.item_seq DESC
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
    <div class="xmas_logo"><img src="./img/logo_xmas_silver.png"/></div>
    <div class="gift_box_area">
      <h1><?php print($item_name); ?></h1>
      <figure style="position: relative;">
        <img src="./img/<?php print($item_image_file); ?>"/>
        <img class="open_box" src="./img/giftbox_empty_mini.png"/>
      </figure>
      <h1 class="item_description"><?php print($item_description); ?></h1>
      <br/>
      <br/>
      <h1><a href="/">サンタの部屋へ戻る</a></h1>
    </div>
    <div id="fadeLayer"></div>
    <script type="text/javascript">
    <!--
    $("#fadeLayer").fadeOut("slow");
    </script>
    <script type="text/javascript" src="./js/snowparticle.smart.1.js"></script>
  </body>
</html>
