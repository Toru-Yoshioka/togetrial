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
    <p>▼
<?php
$x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
print ($x_forwarded_for . '<br/>');
$remote_host = gethostbyaddr($x_forwarded_for);
print ($remote_host . '<br/>');
//foreach($_SERVER as $key=>$value) {
//  if (substr($key,0,5)=="HTTP_") {
//    // $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
//    print ('KEY:'. $key . '<br/>');
//    // $out[$key]=$value;
//    print ('VALUE:'. $value . '<br/>');
//  }
//}
?>
    ▲</p>
    <div id="fadeLayer"></div>
  </body>
</html>
