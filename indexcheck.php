<?php
date_default_timezone_set('Asia/Tokyo');
$conn = "host=ec2-23-23-199-72.compute-1.amazonaws.com dbname=d25481250mtets user=mtrdhlivfehdrj password=lhXZgchb6JgtNPmToWmF3yaZlh";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}

$result = pg_query('
SELECT
 item_seq,
 item_name,
 item_image_file,
 item_description
FROM
 unsuccessful_items
ORDER BY
 item_seq DESC
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
    <title>Togekichi presents Xmas Advent Gift</title>
    <script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="css/swiper.min.css">
    <script src="js/swiper.min.js"></script>
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
    .secret_item {
      -webkit-filter: brightness(0.05);
      -moz-filter: brightness(0.05);
      -o-filter: brightness(0.05);
      -ms-filter: brightness(0.05);
      filter: brightness(0.05);
      width: auto;
      height: 50%;
    }
    ul {
      list-style:none;
    }
    .first_item {
      float:left;
    }
    .other_item {
      display: block;
      float:left;
      border: solid 1px #ffffff;
      width: 180px;
      height: auto;
    }
    .item_gallery_title {
      clear: both;
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

    <div class="xmas_logo">
<?php
  if ($_GET['r'] === '1') {
?>
      <img src="./img/logo_xmas_successed.png"/>
          <h2>今日はすでに当たり箱を開けました</h2>
<?php
  } else {
?>
      <img src="./img/logo_xmas.png"/>
<?php
  }
?>
    </div>

  <div class="swiper-container swiper-container-horizontal">
    <div class="swiper-wrapper">
	  <div class="swiper-slide">

        <!-- page 1 -->
<?php
  if ($_GET['mode'] === '') {
?>
        <div class="gift_box_area">
          <a href="javascript:fade();">
            <img src="./img/giftbox_off.png"/>
          </a>
          <h1>ギフトボックスをタップしてネ♪</h1>
        </div>
<?php
  } elseif ($_GET['mode'] === 'empty') {
?>
        <div class="gift_box_area">
          <h1>お手伝いしてほしい箱は今は無いみたい。<br/>また、時間が経ったら来てみてね♪</h1>
        </div>
<?php
  } elseif ($_GET['mode'] === 'next') {
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
	  </div>
	  <!-- page 1 -->

      <!-- page 2 -->
	  <div class="swiper-slide">
        <div class="gift_box_area">
          <ul>
<?php
  for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
    $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $item_name = $rows['item_name'];
    $item_image_file = $rows['item_image_file'];
?>
            <li class="other_item">
              <a href="#">
                <img class="secret_item" src="./img/<?php print($item_image_file); ?>"/><br/>
                <h4><?php print($item_name); ?></h4>
              </a>
            </li>
<?php
  }
?>
          </ul>
          <br/>
          <h1 class="item_gallery_title">はずれ箱ぎゃらりぃ</a></h1>
        </div>
	  </div>
	  <!-- page 2 -->

    </div>

	<div class="swiper-pagination"></div>
	<div class="swiper-button-prev swiper-button-white"></div>
	<div class="swiper-button-next swiper-button-white"></div>
	<div class="swiper-scrollbar"></div>

  </div>

  <script type="text/javascript">
  <!--
    var swiper = new Swiper('.swiper-container', {
      pagination: '.swiper-pagination',
      paginationClickable: true,
      nextButton: '.swiper-button-next',
      prevButton: '.swiper-button-prev',
      parallax: true,
      speed: 600,
    });
  //-->
  </script>
  </body>
</html>
