<?php
session_start();
if (isset($_GET['mode'])) {
  unset($_SESSION['logedin']);
} else {
  if (! isset($_SESSION['logedin'])) {
    if(isset($_POST['loginkey'])){
      if ($_POST['loginkey'] == 'togesmasmainte') {
        $_SESSION['logedin'] = 'mainte';
      }
    }
  }
}
?>
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
  if (isset($_SESSION['logedin'])) {
    $now_date = date('Y-m-d');
?>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
    <div class="gift_box_area">
      <h1>パケット登録</h1>
      <form method="post" action="./mainte.php">
        パケット容量: <select name="packet_size">
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="40">40</option>
        <option value="50" selected="true">50</option>
        <option value="60">60</option>
        <option value="70">70</option>
        <option value="80">80</option>
        <option value="90">90</option>
        <option value="100">100</option>
        </select><br/>
        <input type="text" style="height: 24px; width: 320px; font-size: x-large;" name="gift_code"/><br/>
        <input type="text" style="height: 24px; width: 320px; font-size: x-large;" name="created_date" value="<?php print($now_date); ?>"/><br/>
        <input type="submit" style="width: 320px; height: 240px;" value="登録"/>
        <br/>
        <br/>
        <input type="button" style="width: 320px; height: 240px;" onClick="location.href='./mainte.php?mode=logout'" value="ログアウト"/>
      </form>
    </div>
<?php
  } else {
?>
    <div class="xmas_logo"><img src="./img/logo_xmas.png"/></div>
    <div class="gift_box_area">
      <h1>ログイン</h1>
      <form method="post" action="./mainte.php">
        <input type="password" style="height: 24px; width: 320px; font-size: x-large;" name="loginkey"/><br/>
        <input type="submit" style="width: 320px; height: 240px;" value="ログイン"/>
      </form>
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
