<?php
date_default_timezone_set('Asia/Tokyo');
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
  $lot_result = 1;
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
    </script>
    <script type="text/javascript" src="./js/snowparticle.smart.1.js"></script>
  </body>
</html>
