<html>
  <head>
    <title>Togekichi presents Xmas Gift Maintenance</title>
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
//  if ($lot_result > 0) {
?>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
    <div class="gift_box_area">
      <h1>ログイン</h1>
      <form method="post" action="./mainte.php">
        <input type="text" name="loginkey"/><br/>
        <input type="submit" value="ログイン"/>
      </form>
    </div>
<?php
//  } else {
?>
    <div class="gift_box_area">
    </div>
<?php
//  }
?>
    <div id="fadeLayer"></div>
    <script type="text/javascript">
    <!--
    $("#fadeLayer").fadeOut("slow");
    </script>
    <script type="text/javascript" src="./js/snowparticle.smart.1.js"></script>
  </body>
</html>
