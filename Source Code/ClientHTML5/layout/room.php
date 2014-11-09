<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Room</title>

<script src="../Javascript/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="../add-in/fancyapps-fancyBox-18d1712/lib/jquery.mousewheel-3.0.6.pack.js" type="text/javascript"></script>
<script src="../add-in/fancyapps-fancyBox-18d1712/source/jquery.fancybox.js?v=2.1.5" type="text/javascript"></script>
<link href="../add-in/fancyapps-fancyBox-18d1712/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" rel="stylesheet" />

<script src="../add-in/fancyapps-fancyBox-18d1712/source/jquery.fancybox.js" type="text/javascript"></script>
<script src="../add-in/fancyapps-fancyBox-18d1712/source/jquery.fancybox.pack.js" type="text/javascript"></script>

<script src="../Javascript/room.js" type="text/javascript"></script>


<link href="../add-in/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
<link href="../CSS/room.css" rel="stylesheet" type="text/css" />
<link href="../CSS/index.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php require('header.php'); ?>
<div id="main">
  <div id="help">
    <div id="more1"><span class="glyphicon glyphicon-plus"></span></div>
    <div id="sound"><span class="glyphicon glyphicon-volume-up"></span></div>
    <div id="back"><span class="glyphicon glyphicon-remove"></span></div>
  </div>
  <div id="info">
    <div id="name-info">Emma Watson</div>
    <div id="avt"><img src="../images/avt1.jpg" style="width:140px;" class="img-rounded"></div>
    <div id="rank">Rank : 12</div>
    <div id="rick">Money: 120$</div>
    <div id="medal">Gà bô lão</div>
  </div>
  <div id="list-room">
    <div id="head-list">
        <div id="room-id">ID</div>
        <div id="room-name">Tên phòng chơi</div>
        <div id="number-player">Slg</div>
        <div id="room-money">Tiền cược</div>
        <div id="room-pass">Mật khẩu</div>
    </div>
    <div id="content-list">
   
    <table>
    	<tr class="items">
        	<td>
            <div class="id"></div>
            <div class="name"></div>
            <div class="quantity"></div>
            <div class="money"></div>
            <div class="password"></div>
            </td>
		</tr>	      
    
    
    </table>
    
    </div>
  </div>
  <div id="friend">
  <div id="list-name">Danh sách bạn bè</div>
  <form action="#" method="post" style="width:140px;height:40px; float:left; margin:5px; padding:2px;">
  <input type="text" class="form-control" placeholder="Tìm bạn bè..." size="6" style="width:96px;float:left;border-bottom-right-radius:0%;border-top-right-radius:0%;" />
  <button type="button" class="btn btn-success" style="float:left;width:40px;height:34px; border-bottom-left-radius:0%;padding-left:4px;;
  border-top-left-radius:0%;"><span class="glyphicon glyphicon-search"></span></button>
  </form>
  <div id="list-fri">
  <div class="friend">
  <a href="#" id="fri1">
  	<div class="fri-name">Trần Huy</div>
    <div class="fri-rank">245</div>
  </a>
  </div>
   <a href="#" class="friend" id="fri2">
  	<div class="fri-name">Lê Huy</div>
    <div class="fri-rank">33</div>
  </a>
   <a href="#" class="friend" id="fri3">
  	<div class="fri-name">Adam </div>
    <div class="fri-rank">23</div>
  </a>
   <a href="#" class="friend" id="fri4">
  	<div class="fri-name">Ando</div>
    <div class="fri-rank">335</div>
  </a>
   <a href="#" class="friend" id="fri5">
  	<div class="fri-name">Chesse</div>
    <div class="fri-rank">185</div>
  </a>
  </div>
  
  
  </div>
  <div id="more">
    <a id="new" href="#data"><button type="button" class="btn btn-danger">Tạo bàn <span class="glyphicon glyphicon-plus-sign"></span></button></a>
<style type="text/css">


.fancybox-overlay fancybox-overlay-fixed
{
}
</style>
    
    <div id="shop"><button type="button" class="btn btn-danger" disabled="disabled">Shop<small style="color:#CCC">(Chưa mở)</small></button></div>
    <div id="guide"><a href="/cotuong/?page=howtoplay"><button type="button" class="btn btn-danger">Hướng dẫn</button></a></div>
    <div id="top-board"><a href="/cotuong/layout/bill-board"><button type="button" class="btn btn-danger">Bảng xếp hạng</button></a>	</div>
  </div>
</div>
<?php require('footer.php'); ?>
</body>
</html>