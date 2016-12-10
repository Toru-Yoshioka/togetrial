<?php
$i = mt_rand(0, 99);
$ip = $_SERVER['REMOTE_ADDR'];
$hs = gethostbyaddr($ip);
$ua = $_SERVER['HTTP_USER_AGENT'];
$rf = $_SERVER['HTTP_REFERER'];
$ck = $_COOKIE['TOGE_XMAS_PRESENT'];
if ($ck == '') {
  $setck = md5(uniqid());
  setcookie('TOGE_XMAS_PRESENT', $setck);
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
    }
    
    //-->
    </script>
  </head>
  <body>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
    <p>DEBUG:■REMOTE_ADDR[<?php print($ip); ?>]■<br/>
    ■REMOTE_HOST[<?php print($hs); ?>]■<br/>
    ■USER_AGENT[<?php print($ua); ?>]■<br/>
    ■REFERER[<?php print($rf); ?>]■<br/>
    ■COOKIE[<?php print($ck); ?>]■<br/>
    ■RANDOM[<?php print($i); ?>]■</p>
<?php
  if ($i <= 1 and $i >= 30) {
?>
    <div class="gift_box_area">
      <a href="javascript:fade();">
        <img src="./img/giftbox_off.png"/>
      </a>
      <a href="javascript:fade();">
        <img src="./img/giftbox_off.png"/>
      </a>
      <a href="javascript:fade();">
        <img src="./img/giftbox_off.png"/>
      </a>
    </div>
    <div id="fadeLayer"></div>
<?php
  } else {
  }
?>
  </body>
</html>
