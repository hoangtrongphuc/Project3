<?php $baseurl = 'http://localhost/cotuong'; ?>
<div id="header">
 
<?php
   $howtoplay = $tintuc =$aboutus = $contactus =$info = $napxu = $trangchu = '';
  if(isset($_GET['page'])){
    switch ($_GET['page']) {
      case 'aboutus': $aboutus = 'active';
        break;
      case 'howtoplay': $howtoplay = 'active';
        break;
      case 'contactus': $contactus = 'active';
        break;
      case 'info': $info = 'active';
        break;
      case 'napxu': $napxu = 'active';
        break;
      case 'tintuc': $tintuc = 'active';
        break;
      default:
        break;
    }

  }
  else
  {
    $trangchu = 'active';
  }
 ?>
    <div id="menu">
    <ul id="nav" class="js">
    	<li class="<?php echo $trangchu; ?>">
        <a href="/cotuong">Trang chủ</a></li>
    	<li class="<?php echo $aboutus; ?>">
        <a href="/cotuong?page=aboutus">Giới thiệu</a></li>
    	<li class="<?php echo $napxu; ?>">
        <a href="/cotuong?page=napxu">Nạp xu</a></li>
    	<li class="<?php echo $tintuc; ?>">
        <a href="/cotuong?page=tintuc">Tin tức</a></li>
    	<li class="<?php echo $howtoplay; ?>">
        <a href="/cotuong?page=howtoplay">Hướng dẫn</a></li>
    	<li class="<?php echo $contactus; ?>">
        <a href="/cotuong?page=contactus">Liên hệ</a></li>
</ul>
<div id="marquee"><marquee direction="left" contenteditable="false" scrollamount="3" onmouseover="this.stop()" onmouseout="this.start()" title="Viết cái title vào đây!!" dropzone="link"  >Chào mừng các bạn đến với website chơi cờ tướng trực tuyến lô cồ hót</marquee></div>
    </div>
    
  </div>