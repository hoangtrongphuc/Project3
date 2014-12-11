<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cờ tướng online</title>
<link rel="stylesheet" type="text/css" href="CSS/index.css" >
<link rel="stylesheet" type="text/css" href="add-in/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="CSS/font/CODE Light.otf" />
<script src="Javascript/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="add-in/md5js-master/md5js.js" type="text/javascript"></script>
<script src="Javascript/examplecard.js" type="text/javascript"></script>
<script>
function getCookie(cname) {
					var name = cname + "=";
					var ca = document.cookie.split(';');
					for (var i = 0; i < ca.length; i++) {
						var c = ca[i];
						while (c.charAt(0) === ' ')
							c = c.substring(1);
						if (c.indexOf(name) !== -1)
							return c.substring(name.length, c.length);
					}
					return "";
					}
			
 $("document").ready(function(){
				var getcookie_id = getCookie("cookie_id");
			if(getcookie_id !== ""){
					window.location.href = "http://localhost:8080/cotuong/banco";
					return false;
				}
				});
</script>
</head>

<body>


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