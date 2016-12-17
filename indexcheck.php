<?php
date_default_timezone_set('Asia/Tokyo');
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
<?php
  if ($_GET['moode'] === '') {
?>
    <div class="gift_box_area">
      <a href="javascript:fade();">
        <img src="./img/giftbox_off.png"/>
      </a>
      <h1>ギフトボックスをタップしてネ♪</h1>
    </div>
<?php
  } elseif ($_GET['moode'] === 'empty') {
?>
    <div class="gift_box_area">
      <h1>お手伝いしてほしい箱は今は無いみたい。<br/>また、時間が経ったら来てみてね♪</h1>
    </div>
<?php
  } elseif ($_GET['moode'] === 'next') {
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
