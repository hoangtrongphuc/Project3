<!DOCTYPE html>
<html>
    <head>
        <title>Online Chinese Chess</title>
        <meta charset="UTF-8">
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/socket.io.js"></script>
        <script type="text/javascript" src="js/chinese_chess.js"></script>
		<script src="js/tabcontent.js" type="text/javascript"></script>
		<link href="css/tabcontent.css" rel="stylesheet" type="text/css" />
        <link title="text/css" href="css/chinese_chess.css" rel="stylesheet"/>
		<link title="text/css" href="css/menu.css" rel="stylesheet"/>

        <link title="text/css" href="css/style.css" rel="stylesheet"/>
        <link title="text/css" href="css/jquery-ui.css" rel="stylesheet"/>
        <link title="text/css" href="css/jquery-ui.theme.css" rel="stylesheet"/>
        <link title="text/css" href="css/jquery-ui.structure.css" rel="stylesheet"/>
        <script>
            var roomID;
            window.onbeforeunload = onBeforeUnload;
            window.onunload = onUnload;
            $("document").ready(function(){
                controller.initController("chessBoardDiv");

	
                $("#newRoomDialog").dialog({
                    autoOpen: false, 
                    buttons: {
                        "Hủy": function(){
                            $("#newRoomDialog").dialog("close");
                        },
                        "Tạo": function(e){
						var roomName = document.forms["newRoomForm"]["roomName"].value;
						var roomMatch = document.forms["newRoomForm"]["roomMatch"].value;
						var roomCoin = document.forms["newRoomForm"]["roomCoin"].value;
						var roomPass = document.forms["newRoomForm"]["roomPass"].value;
						var check = /^\d+$/i;
						if (roomName == null || roomName =="") {
						alert("Thiếu tên phòng chơi");
						document.forms["newRoomForm"]["roomName"].focus();
						e.preventDefault();
						}
						else if (roomMatch == null || roomMatch == "" || roomMatch <= 0 || !(roomMatch).match(check)) {
						alert("Số trận không hợp lệ");
						document.forms["newRoomForm"]["roomMatch"].focus();
						e.preventDefault();
						}
						else if (roomCoin == null || roomCoin <= 500 || !(roomCoin).match(check)) {
						alert("Tiền cược phải lớn hơn 500 xu");
						document.forms["newRoomForm"]["roomCoin"].focus();
						e.preventDefault();
						}
						else {
                            var ob = {};
                            ob.name = $("#roomName").val();
                            ob.match = $("#roomMatch").val();
                            ob.coin = $("#roomCoin").val();
                            ob.pass = $("#roomPass").val();
                            controller.addRoom(ob);
                            $("#newRoomDialog").dialog("close");
							}
                        }
                    },
                    title: "Tạo phòng chơi",
                    height: 360,
                    width: 300,
                    modal: true
                });
                
                $("#friendRequestDiv").dialog({
                    autoOpen: false,
                    title: "Yêu cầu kết bạn",
                    modal: true
                });
                
                $("#passwordDialog").dialog({
                    autoOpen: false, 
                    buttons: {
                        "Hủy": function(){
                            $("#passwordDialog").dialog("close");
                            $("#pass").val('');
                        },
                        "Tham gia": function(){
                            controller.joinRoom(roomID, $("#pass").val());
                            $("#passwordDialog").dialog("close");
                            $("#pass").val('');
                        }
                    },
                    title: "Tham gia phòng chơi",
                    height: 200,
                    width: 300,
                    modal: true
                });
				
				$("#addCoinDialog").dialog({
                    autoOpen: false, 
                    buttons: {
                        "Hủy": function(){
                            $("#addCoinDialog").dialog("close");
                            $("#pass").val('');
                        },
                        "Nạp xu": function(){
                            onAddCoin();
                            $("#addCoinDialog").dialog("close");
                            $("#serialNumber").val('');
                        }
                    },
                    title: "Nạp thẻ điện thoại",
                    height: 400,
                    width: 300,
                    modal: true
                });
				
				$("#contactDialog").dialog({
                    autoOpen: false, 
                    buttons: {
                        "Hủy": function(){
                            $("#contactDialog").dialog("close");
                           
                        },
                        "Gửi ý kiến": function(){
                            controller.joinRoom(roomID, $("#pass").val());
                            $("#contactDialog").dialog("close");
                          
                        }
                    },
                    title: "Liên hệ",
                    height: 400,
                    width: 300,
                    modal: true
                });
				
				$("#inforDialog").dialog({
                    autoOpen: false, 
                    buttons: {
                        "Đóng": function(){
                            $("#inforDialog").dialog("close");
                           
                        },
                        "Lưu": function(){
                            controller.joinRoom(roomID, $("#pass").val());
                            $("#inforDialog").dialog("close");
                          
                        }
                    },
                    title: "Thông tin tài khoản",
                    height: 600,
                    width: 600,
                    modal: true
                });
                
                $("#messageDialog").dialog({
                    autoOpen: false,
                    buttons: {
                        "Đóng":function(){
                            $("#messageDialog").dialog('close');
                        }
                    },
                    height: 200,
                    width: 300,
                    modal: true,
                    title: "Thông báo"
                });
            });    
            function joinRoom(id, havePass){
                    roomID = id;
                    if(havePass){
                        $("#passwordDialog").dialog('open');
                    }else{
                        controller.joinRoom(roomID, "");
                    }
            }
            function addRoom(){
                $('#newRoomDialog').dialog('open')
            }
			 function addCoin(){
                $('#addCoinDialog').dialog('open')
            }
			
			function contact(){
                $('#contactDialog').dialog('open')
            }
			
			function infor(){
                $('#inforDialog').dialog('open')
            }
			
            function onUnload(){
                if(document.location.hash==="#roomDiv"){
                    controller.leavePage();
                }
				else if(document.location.hash==="#listRoomDiv"){
				 return "Bạn đã đăng xuất!";
				}
				
            }
			
			function onSignOut()
			{
			  $.ajax({
					url : "http://localhost:8080/rest/admin/index.php?api=logout",
					type : "post",
					dataType : "json",
					data: "user_id="+$.cookie("cookie_id"),
					async : false,
					success: function(e){
						window.location.href = "http://localhost:8080/cotuong";
					},
					error : function(err){}
						});
					var cookies = $.cookie();
					for(var cookie in cookies) {
						$.removeCookie(cookie);
							}
			}
			
			onTopRank();
			function onTopRank()
			{
			  var $stt = 1;
				$.ajax({
				url : "http://localhost:8080/rest/index.php?api=toprank",
				type : "post",
				dataType : "json",
				data : null,
				async : false,
				success : function(result){
					alert(JSON.stringify(result));
					var jsonData = JSON.parse(JSON.stringify(result));
					for(var i=0; i<jsonData.data.length; i++){
						var datas = jsonData.data[i];
						if(datas.user_level != 1){
							if($stt == 1){
								$("#view2").append(
									"<div class='row1'>"+
										"<div class='stt' ><span class='glyphicon glyphicon-flag'>"+$stt+"</span></div>"+
										"<div class='name'>"+datas.user_name+"</div>"+
										"<div class='point'>"+datas.user_win+"</div>"+
									"</div>"
								);
							}
							else{
								$("#view2").append(
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
			
			function onGetEvent()
			{
			  $.ajax({
					url : "http://localhost:8080/rest/admin/index.php?api=logout",
					type : "post",
					dataType : "json",
					data: "user_id="+$.cookie("cookie_id"),
					async : false,
					success: function(e){
						window.location.href = "http://localhost:8080/cotuong";
					},
					error : function(err){}
						});
					var cookies = $.cookie();
					for(var cookie in cookies) {
						$.removeCookie(cookie);
							}
			}
			onTopRich();
			function onTopRich()
			{
			  var $stt = 1;
				$.ajax({
				url : "http://localhost:8080/rest/index.php?api=toprick",
				type : "post",
				dataType : "json",
				data : null,
				async : false,
				success : function(result){
					var jsonData = JSON.parse(JSON.stringify(result));
					for(var i=0; i<jsonData.data.length; i++){
						var datas = jsonData.data[i];
						if(datas.user_level != 1){
							if($stt == 1){
								$("#richList").append(
									"<div class='row1'>"+
										"<div class='stt' ><span class='glyphicon glyphicon-flag'>"+$stt+"</span></div>"+
										"<div class='name'>"+datas.user_name+"</div>"+
										"<div class='point'>"+datas.user_coin+"</div>"+
									"</div>"
								);
							}
							
							else{
								$("#richList").append(
										"<div class='row1'>"+
										"<div class='stt'>"+$stt+"</div>"+
										"<div class='name'>"+datas.user_name+"</div>"+
										"<div class='point'>"+datas.user_coin+"</div>"+
									"</div>"
								);
																alert($("#view1").val());

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
			
			function onSendContact()
			{
			  $.ajax({
					url : "http://localhost:8080/rest/admin/index.php?api=logout",
					type : "post",
					dataType : "json",
					data: "user_id="+$.cookie("cookie_id"),
					async : false,
					success: function(e){
						window.location.href = "http://localhost:8080/cotuong";
					},
					error : function(err){}
						});
					var cookies = $.cookie();
					for(var cookie in cookies) {
						$.removeCookie(cookie);
							}
			}
			
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
			
			
			
			
			function onAddCoin()
			{
			var id = getCookie("cookie_id");
			var provider = $("#coinProvider").val();
			var code = $("#secretCode").val();
			var serial = $("#serialNumber").val();
			var xu = 1;
			var date = new Date();
			ngay = date.getDate();
		
			$.ajax({
			url : "http://localhost:8080/rest/index.php?api=napxu",
			type : "post",
			dataType : "json",
			data : "xu="+xu+"&user_id="+id+"&provider="+provider+"&code="+code+"&serial="+serial+"&date="+ngay,
			async : false,
			success : function(result){
				alert(JSON.stringify(result));
			},
			error : function(err){
				alert(JSON.stringify(err));
			}
			});
			}
			
			function onListFriend()
			{
			  $.ajax({
					url : "http://localhost:8080/rest/admin/index.php?api=logout",
					type : "post",
					dataType : "json",
					data: "user_id="+$.cookie("cookie_id"),
					async : false,
					success: function(e){
						window.location.href = "http://localhost:8080/cotuong";
					},
					error : function(err){}
						});
					var cookies = $.cookie();
					for(var cookie in cookies) {
						$.removeCookie(cookie);
							}
			}
			
            function onBeforeUnload(){
                if(document.location.hash==="#roomDiv"){
                    return "Nếu bạn rời đi, phòng chơi sẽ bị hủy ?";
                }
				else if(document.location.hash==="#roomDiv"){
					signOut();
				}
            }
        </script>
    </head>
    <body onhashchange="controller.onHashChange()" onload="controller.onHashChange()">
     
		<div id="bodyDiv" >     
            <div id="listRoomDiv" style="width:100%">
			<div id="mainnav"> 
			<ul>
				<li><a href="#" class="active" title="Trang chủ">Trang chủ</a></li>    
				<li><a href="#" title="Giới thiệu">Giới thiệu</a></li>    
				<li><a onclick="addCoin()" href="javascript:void(0);" title="Nạp xu">Nạp xu</a></li>    
				<li><a onclick="infor()" href="javascript:void(0);" title="Thông tin cá nhân">Thông tin cá nhân</a></li>    
				<li><a onclick="contact()" href="javascript:void(0);" title="Liên hệ">Liên hệ</a></li>  
				<li><a href="#" title="Đăng xuất">Đăng xuất</a></li>  
			</ul>  
			</div>

			<font FONT SIZE="4" FACE="courier" COLOR=white >
			<marquee  behavior="scroll"  direction="left">Your scrolling text goes here</marquee>
			</font><br/><br/><br/>
			<div id="wrapper" style="width:100%;">
			 	<div style="float:right;height:25%;width:25%">
				<ul class="tabs" >
				<li class="selected"><a href="#view1">Top cao thủ</a></li>
				<li><a href="#view2">TOP triệu phú</a></li>
				<li><a href="#view3">Bạn bè</a></li>
				</ul>
				<div class="tabcontents">
				<div id="richlist">
				<div class="row1">
				<div class="stt">Hạng</div>
				<div class="name">Tên người chơi</div>
				<div class="point">Điểm</div>
				</div>
				</div>
				<div id="view2">
				</div>
				<div id="view3">
				</div>
				</div> 
				</div>	
			 <div id="globalChat" style="float:left;height:20%;width:20%">
                        <form onsubmit="controller.chatInRoom();">
							<textarea style=" overflow: scroll;height:220px;width:220px"></textarea>
							<br/>
                            <input id="messageInput" type="text">
                            <button class="button" id="sendButton" onclick="controller.chatGlobal();">Gửi</button>
                        </form>
             </div>
			<div style= "width:54%; float:left;">
                <div id="roomTableDiv" >
                    <table id="roomTable"></table>
                </div>
                <div id="roomControlDiv">
                    <button class="button" id="createRoomButton" onclick="addRoom();">TẠO PHÒNG</button>
                    <button class="button" id="refreshRoomButton" onclick="controller.refreshRoom();">CẬP NHẬT PHÒNG CHƠI</button>
                </div>
			</div>
				
			</div>
            </div>
			
			
            <div id="roomDiv">
                <div id="leftBoardDiv">
                    <div id="user1Div"></div>
                    <div id="timerDiv"></div>
                    <div id ="user2Div"></div>
                </div>
                <div id="chessBoardDiv"></div>
                <div id="rightBoardDiv">
                    <div id="roomInfoDiv"></div>
                    <div id="messagesDiv"></div>
                    <div id="typeDiv">
                        <form onsubmit="controller.chatInRoom();">
                            <input id="messageInput" type="text">
                            <button class="button" id="sendButton" onclick="controller.chatInRoom();">Gửi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		
		
        <div id="footer">

        </div>
          <div id="passwordDialog" class="dialog">
            <form id="passForm">
                <label>Password: </label>
                <input type="text" id="pass">
            </form>
        </div>
		
				
        <div id="newRoomDialog" class="dialog">
            <form id="newRoomForm" ">
                <label for="roomName">Tên phòng: </label> 
                <input type="text" id="roomName" name="roomName" ><br/>
                <label for="roomMatch">Số trận: </label> 
                <input type="text" id="roomMatch" name="roomMatch" ><br/>
                <label for="roomCoin">Tiền cược: </label> 
                <input type="text" id="roomCoin" name="roomCoin" ><br/>
                <label for="roomPass">Password: </label> 
                <input type="text" id="roomPass" name="roomPass" ><br/>
            </form>
        </div>
		
		<div id="contactDialog" class="dialog">
            <form id="contactForm">
                <label>Tiêu đề: </label> <br/><br/>
                <input type="text" id="titleName" name="titleName" ><br/>
                <label>Nội dung: </label><br/> <br/> 
                <textarea type="text" id="content" name="content" rows="7" cols="32"></textarea><br/>

            </form>
        </div>
		
		<div id="inforDialog" class="dialog">
				<ul class="tabs">
					<li><a href="#viewInfor">Thông tin cá nhân</a></li>
					<li><a href="#viewChange">Chỉnh sửa</a></li>
				</ul>
				<div class="tabcontents">
				<div id="viewInfor">
				
				<table id="info-table" width="500" border="0" cellspacing="20">
          <tr>
          <td><label class="col-sm-2 control-label" style="width:200px; margin:0; padding:0;">Tên tài khoản</label></td>
            <td  height="50" colspan="2"><div class="col-sm-10">
      <p class="form-control-static">nghiait0111</p>
		</div></td>      
          </tr>
          <tr>
          <td> Mật khẩu</td>
            <td  height="50" colspan="2"><input style="width:300px;" type="password" class="form-control" placeholder="*********" name="user_pass" required></td>
          </tr>
          <tr>
          <td>Email đăng kí</td>
            <td   height="50" colspan="2"><input style="width:300px;" type="text" class="form-control" placeholder="Email đăng ký" name="user_repass" required></td>
          </tr>
          <tr>
          <td>Số xu hiện có: </td>
            <td  height="50" colspan="2"><input  style="width:200px;" type="text" class="form-control" placeholder="Số lượng tiền" name="rich" required></td>
          </tr>
          <tr>
          <td>Xếp hạng: </td>
            <td  height="50" colspan="2"><input  style="width:200px;" type="text" class="form-control" placeholder="Điểm rank" name="rich" required></td>
          </tr>
          <tr>
          <td></td>
          </tr>
        </table>
				
				</div>
				
				<div id="viewChange">
				
				<table id="info-table" width="500" border="0" cellspacing="20">
         
          <tr>
          <td> Tên tài khoản</td>
            <td  height="50" colspan="2"><input style="width:300px;" type="password" class="form-control" name="user_pass" required></td>
          </tr>
          <tr>
          <td>Email đăng kí</td>
            <td   height="50" colspan="2"><input style="width:300px;" type="text" class="form-control" name="user_repass" required></td>
          </tr>
		  <tr>
          <td>Giới tính</td>
            <td   height="50" colspan="2"><input style="width:300px;" type="text" class="form-control"  name="user_repass" required></td>
          </tr>
		  <tr>
          <td>Địa chỉ</td>
            <td   height="50" colspan="2"><input style="width:300px;" type="text" class="form-control"  name="user_repass" required></td>
          </tr>
         
          <tr>
          <td></td>
          </tr>
        </table>
				
				</div>
				</div> 
        </div>
		
        <div id="messageDialog"></div>
		
		<div id="addCoinDialog" class="dialog">
            <form id="addCoinForm">
                <label>Nhà cung cấp: </label> 
                <select id = "coinProvider">
				<option value="volvo">Viettel</option>
				<option value="saab">Vinaphone</option>
				<option value="mercedes">Mobiphone</option>
				</select>
				<br/>
				<br/>
				<br/>
                <label for="serialNumber">Số serial: </label> 
                <input type="text" id="serialNumber" name="serialNumber" ><br/><br/>
                <label for="secretCode">Secret Code: </label> 
                <input type="text" id="secretCode" name="secretCode" ><br/>

            </form>
        </div>
		
    </body>
</html>