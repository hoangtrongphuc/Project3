<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bảng xếp hạng</title>
<link rel="stylesheet" type="text/css" href="../CSS/top.css" >
<link rel="stylesheet" type="text/css" href="../CSS/index.css" >
<link rel="stylesheet" type="text/css" href="../add-in/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../CSS/font/CODE Light.otf" />
</head>
<script src="../Javascript/jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../config.js"></script>
<script type='text/javascript'>
	$(document).ready(function(){
		topRick();
		function topRick(){
			var $stt = 1;
			$.ajax({
				url : "http://"+host+"/rest/index.php?api=toprick",
				type : "post",
				dataType : "json",
				data : null,
				async : false,
				success : function(result){
					//alert(JSON.stringify(result));
					var jsonData = JSON.parse(JSON.stringify(result));
					for(var i=0; i<jsonData.data.length; i++){
						var datas = jsonData.data[i];
						if(datas.user_level != 1){
							if($stt == 1){
								$("#richlist").append(
									"<div class='row1'>"+
										"<div class='stt' ><span class='glyphicon glyphicon-flag'>"+$stt+"</span></div>"+
										"<div class='name'>"+datas.user_name+"</div>"+
										"<div class='point'>"+datas.user_coin+"</div>"+
									"</div>"
								);
							}
							else{
								$("#richlist").append(
										"<div class='row1'>"+
										"<div class='stt'>"+$stt+"</div>"+
										"<div class='name'>"+datas.user_name+"</div>"+
										"<div class='point'>"+datas.user_coin+"</div>"+
									"</div>"
								);
							}
						$stt++;
						}
					}
				},
				error : function(err){
					alert(JSON.stringify(err));
				}
			});
		}
		//top rank
		topRank();
		function topRank(){
			var $stt = 1;
			$.ajax({
				url : "http://"+host+"/rest/index.php?api=toprank",
				type : "post",
				dataType : "json",
				data : null,
				async : false,
				success : function(result){
					//alert(JSON.stringify(result));
					var jsonData = JSON.parse(JSON.stringify(result));
					for(var i=0; i<jsonData.data.length; i++){
						var datas = jsonData.data[i];
						if(datas.user_level != 1){
							if($stt == 1){
								$("#ranklist").append(
									"<div class='row1'>"+
										"<div class='stt' ><span class='glyphicon glyphicon-flag'>"+$stt+"</span></div>"+
										"<div class='name'>"+datas.user_name+"</div>"+
										"<div class='point'>"+datas.user_win+"</div>"+
									"</div>"
								);
							}
							else{
								$("#ranklist").append(
										"<div class='row1'>"+
										"<div class='stt'>"+$stt+"</div>"+
										"<div class='name'>"+datas.user_name+"</div>"+
										"<div class='point'>"+datas.user_win+"</div>"+
									"</div>"
								);
							}
						$stt++;
						}
					}
				},
				error : function(err){
					alert(JSON.stringify(err));
				}
			});
		}
	});
</script>
<body>
<?php require('../layout/header.php');?>
<div id="wrapper">
  <div id="wp-row2" style="height:960px; padding-left:20px;">
    <div id="content2">
      <div id="logo-bxh">Bảng xếp hạng</div>
      <div id='richandrank'>
        <button id="rich" type="button" class="btn btn-success">Top Rich</button>
        <button id='rank' type="button" class="btn btn-warning">Top Rank</button>
      </div>
      <div id="list">
        <div id="richlist">
          <div class="row1">
            <div class="stt">Hạng</div>
            <div class="name">Tên người chơi</div>
            <div class="point">Điểm</div>
          </div>
        </div>
        <div id="ranklist">
         
        </div><a href="/cotuong"><button class="btn btn-danger" type="button" style="width:300px; height:50px; text-align:center; margin:10px 200px;;"><span class="glyphicon glyphicon-chevron-left"></span><span class="glyphicon glyphicon-chevron-left"></span><span class="glyphicon glyphicon-chevron-left"></span> Quay về trang chủ</button></a>
        </div>
      </div>
    </div>
  
</div>
<?php require('../layout/footer.php');?>
</body>
</html>
