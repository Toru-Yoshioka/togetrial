<?php
  $unique_key = md5(uniqid());
  $lot_result = mt_rand(0, 99);
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

      background-color:#ffffff;
      opacity: 0.0;
      display: block;
      z-index:1;
    }
    //-->
    </style>
  </head>
  <body>
    <div id="fadeLayer"></div>
    <script type="text/javascript">
    <!--
    $("#fadeLayer").fadeOut("slow");
    $(function(){
      setTimeout(function(){
        // window.location.href = './lottery.php';
      },3000);
    });
    //-->
    </script>
  </body>
</html>
