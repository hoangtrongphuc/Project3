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
        <a href="index.php">Trang chủ</a></li>
    	<li class="<?php echo $aboutus; ?>">
        <a href="index.php?page=aboutus">Giới thiệu</a></li>
    	<li class="<?php echo $napxu; ?>">
        <a href="index.php?page=napxu">Nạp xu</a></li>
    	<li class="<?php echo $tintuc; ?>">
        <a href="index.php?page=tintuc">Tin tức</a></li>
    	<li class="<?php echo $howtoplay; ?>">
        <a href="index.php?page=howtoplay">Hướng dẫn</a></li>
    	<li class="<?php echo $contactus; ?>">
        <a href="index.php?page=contactus">Liên hệ</a></li>
</ul>
    </div>
  </div>