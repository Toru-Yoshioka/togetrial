<?php
date_default_timezone_set('Asia/Tokyo');
$ck = $_COOKIE['TSID'];
$rf = $_SERVER['HTTP_REFERER'];
if ($ck == '' and $rf == 'https://togetrial.herokuapp.com/') {
  $unique_key = md5(uniqid());
  setcookie('TSID', $unique_key, time()+30);
} else {
  header('Location: /');
  exit;
}

$x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
$remote_host = gethostbyaddr($x_forwarded_for);
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$lot_rand = mt_rand(0, 999);
$card_no = str_pad(mt_rand(1, 4), 2, 0, STR_PAD_LEFT);

// ヒストリ登録
$conn = "host=ec2-23-23-199-72.compute-1.amazonaws.com dbname=d25481250mtets user=mtrdhlivfehdrj password=lhXZgchb6JgtNPmToWmF3yaZlh";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}

// アクセス頻度チェック
$result = pg_query('
select
 lh.remote_ip,
 lh.between_cnt
from
(
select
 remote_ip,
 count(*) as between_cnt
from
 lottery_history
where
 drawing_timestamp >= current_timestamp - interval \'60 minutes\'
 and
 remote_ip = \'' . $x_forwarded_for . '\'
group by 
 remote_ip
) as lh
where
  lh.between_cnt > 60
');
if (!$result) {
  die('クエリーが失敗しました。(1)'.pg_last_error());
} else {
  $rows_cnt = pg_num_rows($result);
}

// 抽選率振り分け
$lot_result = 0;
if ($is_limit) {
  // 当選済みユーザー
  if ($lot_rand == 777) {
    $lot_result = 1;
  }
｝elseif ($rows_cnt > 0) {
  // アクセス過多ユーザー
  if ($lot_rand >= 0 and $lot_rand <= 4) {
    $lot_result = 1;
  }
} else {
  // 通常ユーザー
  if ($lot_rand >= 0 and $lot_rand <= 49) {
    $lot_result = 1;
  }
}

$result = pg_query('
INSERT INTO
 lottery_history
 (
  lottery_seq,
  unique_key,
  drawing_timestamp,
  drawing_result,
  remote_ip,
  remote_host,
  user_agent
 ) VALUES (
  nextval(\'lottery_seq\'),
  \'' . $unique_key . '\',
  current_timestamp,
  ' . $lot_result . ',
  \'' . $x_forwarded_for . '\',
  \'' . $remote_host . '\',
  \'' . $user_agent . '\'
 )
');
if (!$result) {
    die('クエリーが失敗しました。(2)'.pg_last_error());
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
    die('クエリーが失敗しました。(3)'.pg_last_error());
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
    die('クエリーが失敗しました。(4)'.pg_last_error());
  }
} else {
  // はずれ抽選
  $lose_no = mt_rand(1, 15);

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
    die('クエリーが失敗しました。(5)'.pg_last_error());
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
    a:hover { color: #ffffff; }
    a:visited { color: #ffffff; }
    a:link { color: #ffffff; }
    a:active { color: #ffffff; }
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
    //-->
    </style>
  </head>
  <body>
<?php
  if ($lot_result > 0) {
?>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
    <div class="gift_box_area">
      <h1>『ギフトコード』 がでてきました！</h1>
      <figure style="position: relative;">
        <img src="./img/giftcard_<?php print($card_no); ?>.png"/>
        <figcaption class="gift_info">
          <?php print($gift_code); ?>
        </figcaption>
        <img class="open_box" src="./img/giftbox_empty_mini.png"/>
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
    <div class="xmas_logo"><img src="./img/logo_xmas_silver.png"/></div>
    <div class="gift_box_area">
      <h1><?php print($item_name); ?></h1>
      <figure style="position: relative;">
        <img src="./img/<?php print($item_image_file); ?>"/>
        <figcaption class="gift_info"></figcaption>
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
