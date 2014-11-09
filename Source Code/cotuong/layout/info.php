<div id="wrapper">
<div id="wp-row2" style="height:960px; padding-left:40px;">
<div id="contentinfo">
<ul id="menu1">
	<li id="infomation"><a href="?page=info&id=1">Thông tin chung</a></li>
    <li id="recharge"><a href="?page=info&id=2">Nạp tiền</a></li>
    <li id="logout"><a href="index.php">Thoát</a></li>
</ul>
<div id="main-info">
<?php 
	if (isset($_GET['id'])) {
                                    switch ($_GET['id']) {
                                          case '1' : require('layout/info/infomation.php');
                                          break;
                                          case '2': require('layout/info/card.php');
                                          break;
										  case '3': require('layout/info/firsttime.php');
										  break;
                                    }
                              }
                              else{
                                
                                require('layout/info/infomation.php');
                              }
    

 ?>
</div>
</div>
</div>