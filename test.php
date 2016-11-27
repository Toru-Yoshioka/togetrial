<?php
require "mdetect.php";
// $m = new uagent_info();

$UID=array();
$m=new MobileESP(); //MobileESPを使用
$UA=$_SERVER['HTTP_USER_AGENT']; //ユーザーエージェントを取得
$UID=null; //個体識別番号

/* DoCoMo */
//iモードID
  if(isset($_SERVER['HTTP_X_DCMGUID'],$_GET['guid']) && $_GET['guid']==='ON')
    $UID[]=$_SERVER['HTTP_X_DCMGUID'];
/* au */
//サブスクライバID
  if(isset($_SERVER['HTTP_X_UP_SUBNO']))
    $UID[]=$_SERVER['HTTP_X_UP_SUBNO'];
/* SoftBank */
//X_JPHONE_UID
  if(isset($_SERVER['HTTP_X_JPHONE_UID']))
    $UID[]=$_SERVER['HTTP_X_JPHONE_UID'];
//個体識別情報
  elseif(preg_match('|^.+/SN([0-9a-zA-Z]+).*$|',$UA,$match))
    $UID[]=$match[1];
/* EMOBILE */
  if(isset($_SERVER['HTTP_X_EM_UID']))
    $UID[]=$_SERVER['HTTP_X_EM_UID'];
//携帯端末で、個体識別番号が1つだけ取得出来た場合、個体識別番号を返す
  if($m->DetectTierOtherPhones() && count($UID)===1)
    $UID=$UID[0];
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
    <h3>postgreSQL query result</h3>
    <p>
<?php
  print($UID);
?>
    </p>
  </body>
</html>
