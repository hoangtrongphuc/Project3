<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cờ tướng online</title>
<link rel="stylesheet" type="text/css" href="CSS/index.css" >
<link rel="stylesheet" type="text/css" href="add-in/bootstrap/css/bootstrap.css">

<script src="Javascript/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="add-in/md5js-master/md5js.js" type="text/javascript"></script>
<script src="add-in/fancyapps-fancyBox-18d1712/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" type="text/css" href="add-in/fancyapps-fancyBox-18d1712/source/jquery.fancybox.css" media="screen" />
<script src="add-in/fancyapps-fancyBox-18d1712/source/jquery.fancybox.pack.js"></script>
<link type="text/css" href="add-in/fancyapps-fancyBox-18d1712/source/helpers/jquery.fancybox-buttons.css" rel="stylesheet" />
<script type="text/javascript" src="add-in/fancyapps-fancyBox-18d1712/source/helpers/jquery.fancybox-buttons.js"></script>
<script type="text/javascript" src="add-in/fancyapps-fancyBox-18d1712/source/helpers/jquery.fancybox-media.js"></script>
<script type="text/javascript" src="add-in/fancyapps-fancyBox-18d1712/source/helpers/jquery.fancybox-thumbs.js"></script>
<link type="text/css" href="add-in/fancyapps-fancyBox-18d1712/source/helpers/jquery.fancybox-thumbs.css" media="screen" rel="stylesheet" />
<script src="Javascript/examplecard.js" type="text/javascript"></script>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "18290152-e32f-437c-8142-dffb08b57c05", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

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
<div id="share">
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_email_large' displayText='Email'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
</div>
</body>
</html>