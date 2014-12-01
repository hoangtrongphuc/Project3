<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cờ tướng online</title>
<link rel="stylesheet" type="text/css" href="CSS/index.css" >
<link rel="stylesheet" type="text/css" href="add-in/bootstrap/css/bootstrap.css">
<script src="Javascript/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="add-in/md5js-master/md5js-master/md5js.js" type="text/javascript"></script>
<script src="Javascript/main.js" type="text/javascript"></script>
<script src="Javascript/sighup.js" type="text/javascript"></script>

</head>

<body>
<?php require('layout/header.php'); ?>
<?php
                              if (isset($_GET['page'])) {
                                    switch ($_GET['page']) {
                                          case 'aboutus' : require('layout/aboutus.php');
                                            break;
                                          case 'howtoplay': require('layout/howtoplay.php');
                                            break;
                                          case 'contactus': require('layout/contactus.php');
                                            break;
                                         case 'info':require('layout/info.php');
										                      	break;	
                    										  case 'napxu':require('layout/info.php');
                    										  	break;	
											 
                                    }
                              }
                              else{
                                
                                require('layout/main.php');
                              }
    
                        ?>
 
<?php require('layout/footer.php'); ?>
</body>
</html>