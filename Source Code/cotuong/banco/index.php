<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>zô zô</title>
<link href="../CSS/banco.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="../Javascript/jquery-1.11.1.min.js"></script>
<script src="../libraries/jquery-ui-1.11.1.custom/jquery-ui.min.js" type="text/javascript"></script>
<script src="../libraries/underscore-min.js" type="text/javascript"></script>
<script src="../libraries/GS/TweenMax.min.js"></script>
<script src="../libraries/GS/jquery.gsap.min.js"></script>
<script src="../libraries/GS/utils/Draggable.min.js"></script>
<script src="../libraries/GS/plugins/ScrollToPlugin.min.js"></script>
<script src="../libraries/GS/plugins/RaphaelPlugin.min.js"></script>
<script src="../libraries/GS/plugins/KineticPlugin.min.js"></script>
<script src="../libraries/GS/plugins/ColorPropsPlugin.min.js"></script>
<script src="../libraries/GS/plugins/CSSRulePlugin.min.js"></script>
<script src="../libraries/GS/plugins/EaselPlugin.min.js"></script>
<script src="../libraries/GS/plugins/TextPlugin.min.js"></script>
<script src="../libraries/GS/plugins/ThrowPropsPlugin.min.js"></script>
<script src="../Javascript/game.js" type="text/javascript"></script>
</head>
<body>
<?php $baseurl = 'http://localhost/cotuong' ?>
<div class="board" style="position:absolute;top:25px;left:100px;">
<div class="board_inner" id="board">

<canvas id="chess" width="600" height="600" style="border:1px solid #000;"></canvas>
<div class="pieces">
<div class="mark" id="board-mark">

</div>
</div>

</div>
</div>
<div id="menu">
  <div id="room-name">004 - Thách đấu</div>
  <div id="tat">X</div>
  <div id="turn1"><img src="../images/turn.png"></div>
  <div id="player1">
    <div id="name1">Emma Watson</div>
    <div id="avt1"><img src="../images/avt1.jpg" width="62" height="62"></div>
    <div id="info1">
      <div class="rank"><span><H1>R: 120</H1></span></div>
      <div class="rick"><span><H1>M: 200$</H1></span></div>
      <div class="medal"><span><H1>Trình độ: Gà Con</H1></span></div>
    </div>
    
  </div>
  <div id="time1"><img src="../images/time1.png"></div>
  <div id="vesus"><img src="../images/vs.png"></div>
  <div id="turn2"></div>
  <div id="player2">
    <div id="name2">Adam Levine</div>
    <div id="avt2"><img src="../images/avt2.jpg" width="62" height="62"></div>
    <div id="info2">
      <div class="rank"><span><H1>R: 10</H1></span></div>
      <div class="rick"><span><H1>M: 2200$</H1></span></div>
      <div class="medal"><span><H1>Trình độ: Gà Bô Lão</H1></span></div>
    </div>
  </div>
 <div id="time2"><img src="../images/time2.png"></div>
  <div id="button">
    <a href="#"><img id="bocuoc" src="<?php echo $baseurl.'../../images/xinthua.png'?>" width='74' height='22'></a>
    <a href="#"><img id="dilai" src="<?php echo $baseurl.'../../images/dilai.png'?>" width='74' height='22'></a>
    <a href="#"><img id="xinhoa" src="<?php echo $baseurl.'../../images/xinhoa.png'?>" width='74' height='22'></a>
  </div>
</div>
</body>
</html>