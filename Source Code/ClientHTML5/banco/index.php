<!DOCTYPE html>
<html>
    <head>
        <title>Online Chinese Chess</title>
        <meta charset="UTF-8">
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/socket.io.js"></script>
        <script type="text/javascript" src="js/chinese_chess.js"></script>
		<script type="text/javascript" src="js/jquery.plugin.js"></script> 
		<script type="text/javascript" src="js/jquery.countdown.js"></script>
		<script src="js/tabcontent.js" type="text/javascript"></script>
		<link href="css/tabcontent.css" rel="stylesheet" type="text/css" />
        <link title="text/css" href="css/chinese_chess.css" rel="stylesheet"/>
		<link title="text/css" href="css/menu.css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="css/jquery.countdown.css"> 

        <link title="text/css" href="css/style.css" rel="stylesheet"/>
        <link title="text/css" href="css/jquery-ui.css" rel="stylesheet"/>
        <link title="text/css" href="css/jquery-ui.theme.css" rel="stylesheet"/>
        <link title="text/css" href="css/jquery-ui.structure.css" rel="stylesheet"/>
        <script>
            var roomID;
            window.onbeforeunload = onBeforeUnload;
            window.onunload = onUnload;
            $("document").ready(function(){
			

				var getcookie_id = getCookie("cookie_id");
				if(getcookie_id === ""){
					window.location = "http://localhost:8080/cotuong/index.php";
					return false;
				}
                controller.initController("chessBoardDiv");
			
			onTopRich();
			onTopRank();
			onListFriend();
			onListEvent();
			onMyInfor();
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
                
                $("#passwordDialog").dialog({
                    autoOpen: false, 
                    buttons: {
                        "Hủy": function(){
                            $("#passwordDialog").dialog("close");
                            $("#pass").val('');
                        },
                        "Tham gia": function(){
							if ( $("#pass").val() === "") {
							alert("Bạn chưa nhập Pass");
							e.preventDefault();
							}
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
				
				 $("#helloDialog").dialog({
                    autoOpen: false, 
                    buttons: {
                        "Đóng": function(){
                            $("#helloDialog").dialog("close");
                        }
                    
                    },
                    title: "Welcome !!!",
                    height: 500,
                    width: 500,
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
						var title1 = $("#titleName").val();
						var content = $("#content").val();
                           controller.contactUs(title1,content);
                            $("#contactDialog").dialog("close");
                            $("#titleName").val('');
							$("#content").val('');
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
											var Name, Email,Gender,Address,Tel;
						if($("#user_name").val() !== "" ) Name = $("#user_name").val();
						else Name = $("#user_name").attr("placeholder");
						if($("#user_email").val() !== "" ) Email = $("#user_email").val();
						else Email = $("#user_email").attr("placeholder");
						if($("#user_gender").val() !== "" ) Gender = $("#user_gender").val();
						else Gender = $("#user_gender").attr("placeholder");
						if($("#user_addr").val() !== "" ) Address = $("#user_addr").val();
						else Address = $("#user_addr").attr("placeholder");
						if($("#user_tel").val() !== "" ) Tel = $("#user_tel").val();
						else Tel = $("#user_tel").attr("placeholder");
                            controller.changeInfo(Name,Email,Gender,Address,Tel);
                            $("#inforDialog").dialog("close");
						

                        }
                    },
                    title: "Thông tin tài khoản",
                    height: 660,
                    width: 600,
                    modal: true
                });
                
				 $("#friendRequestDiv").dialog({
                    autoOpen: false,
                    title: "Yêu cầu kết bạn",
                    modal: true
                });
				
				   $("#requestsDialog").dialog({
                    autoOpen: false,
                    title: "Yêu cầu kết bạn",
                    modal: true,
                    width: 400
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

			function hello(){
                $('#helloDialog').dialog('open')
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
			     onMyInfor();
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

			function logOut()
			{
				controller.signOut();
			}
			
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
					var table = $("#rankTable");
					table.html("<tr> <td>Xếp hạng</td> <td>Tên người chơi</td> <td>Số trận thắng</td> </tr>");
					var jsonData = JSON.parse(JSON.stringify(result));
					for(var i=0; i<jsonData.data.length; i++){
						var datas = jsonData.data[i];
						if(datas.user_level != 1){
							if($stt == 1){
								row = "<tr>" + "<td>"+$stt+"</td>"+
										"<td>"+datas.user_name+"</td>"+
										"<td>"+datas.user_win+"</td></tr>";	
							}
							else{
								row = "<tr>" + "<td>"+$stt+"</td>"+
										"<td>"+datas.user_name+"</td>"+
										"<td>"+datas.user_win+"</td></tr>";
							}
						table.append(row);	
						$stt++;
						}
					}
				},
				error : function(err){
					alert(JSON.stringify(err));
				}
			});
			}
			
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
					var table = $("#richTable");
					table.html("<tr> <td>Xếp hạng</td> <td>Tên người chơi</td> <td>Số xu</td> </tr>");
					for(var i=0; i<jsonData.data.length; i++){
						var row;
						var datas = jsonData.data[i];
						if(datas.user_level != 1){
							if($stt == 1){
								row = "<tr>" + "<td>"+$stt+"</td>"+
										"<td>"+datas.user_name+"</td>"+
										"<td>"+datas.user_coin+"</td></tr>";								
							}
							else{
								row = "<tr>" + "<td>"+$stt+"</td>"+
										"<td>"+datas.user_name+"</td>"+
										"<td>"+datas.user_coin+"</td></tr>";
							}
						table.append(row);	
						$stt++;
						}
					}
				},
				error : function(err){
					alert(JSON.stringify(err));
				}
				});
			}


						
			function onListEvent()
			{
			
			$.ajax({
			url : "http://localhost:8080/rest/index.php?api=event&listevent=1",
			type : "post",
			dataType : "json",
			data : null,
			async : false,
			success : function(result){
				var jsonData = JSON.parse(JSON.stringify(result));
				var listEvent = $("#event");
				for(var i=0; i<jsonData.data.length; i++)
				{
					listEvent.append(" - <u>Sự kiện</u> "+"<b>" +jsonData.data[i].event_title + "</b> : " + jsonData.data[i].event_info + " diễn ra từ " +
					jsonData.data[i].event_start +" đến ngày " +jsonData.data[i].event_finish); 
				}
			
			},
			error : function(err){
				alert(JSON.stringify(err));
			}
			});
			}
			
			function onMyInfor()
			{
			var $getuser = 1;
			var $name = getCookie('cookie_username');
			$.ajax({
			url : "http://localhost:8080/rest/index.php?api=user",
			type : "post",
			dataType : "json",
			data : "getuser="+$getuser+"&username="+$name,
			async : false,
			success : function(result){
			var k = JSON.parse(JSON.stringify(result));
				$("#user_name").attr("placeholder",k.data.user_name);
				$("#user_email").attr("placeholder",k.data.user_email);
				$("#user_gender").attr("placeholder",k.data.user_gender);
				$("#user_tel").attr("placeholder",k.data.user_tel);
				$("#user_addr").attr("placeholder",k.data.user_address);
				$("#user_coin").html(k.data.user_coin);
				$("#user_rank").html(k.data.user_win);
			},
			error : function(err){
				alert(JSON.stringify(err));
			}
			});
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
				alert(result.data);
			},
			error : function(err){
				alert(JSON.stringify(err));
			}
			});
			}
			
			function onListFriend()
			{
				var stt = 1;
				var id = getCookie("cookie_id");
				$.ajax({
				url : "http://localhost:8080/rest/index.php?api=friend&listfriend=1",
				type : "post",
				dataType : "json",
				data : "user_id=" +id,
				async : false,
				success : function(result){
					var jsonData = JSON.parse(JSON.stringify(result));
					var table = $("#friendTable");
					table.html("<tr><td>No.</td> <td>Tên bạn bè</td> <td>Trạng thái</td>  </tr>");
					for(var i=0; i<jsonData.data.length; i++){
						var row;
						var datas = jsonData.data[i];
						row = "<tr><td>"+stt+"</td>"+
									"<td>"+datas.user_name+"</td>";		
						if(datas.user_status == 0) row = row + "<td><img src='imgs/off.png' width='10' height='10'/></td></tr>";
						else {
                                                    row = row + "<td ><button onclick='controller.friendClicked(\""+datas.user_name+"\")' class='button'>Chat</button></td></tr>";
                                                }
						table.append(row);	
						stt++;
					}
				},
				error : function(err){
					alert(JSON.stringify(err));
				}
				});
                                setTimeout(onListFriend, 30000);
			}
			
            function onBeforeUnload(){
                if(document.location.hash==="#roomDiv"){
                    return "Nếu bạn rời đi, phòng chơi sẽ bị hủy ?";
                }
				else if(document.location.hash==="#listRoomDiv"){
					logOut();
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
				<li><a onclick="hello()" href="javascript:void(0);" title="Giới thiệu">Giới thiệu</a></li>    
				<li><a onclick="addCoin()" href="javascript:void(0);" title="Nạp xu">Nạp xu</a></li>    
				<li><a onclick="infor()" href="javascript:void(0);" title="Thông tin cá nhân">Thông tin cá nhân</a></li>    
				<li><a onclick="contact()" href="javascript:void(0);" title="Liên hệ">Liên hệ</a></li>  
				<li><a onclick="logOut()" href="javascript:void(0);" title="Đăng xuất">Đăng xuất</a></li>  
			</ul>  
			</div>

			<font FONT SIZE="4" FACE="verdana" COLOR=white >
			<marquee behavior="alternate"  direction="left" id = "event"></marquee>
			</font><br/><br/>
			<div id="wrapper" style="width:100%;">
			 	<div style="float:right;height:25%;width:25%">
				<ul class="tabs" >
				<li class="selected"><a href="#rankTableList">Top cao thủ</a></li>
				<li><a href="#richTableList">TOP triệu phú</a></li>
				<li><a href="#friendTableList">Bạn bè</a></li>
				</ul>
				<div class="tabcontents">
				<div id="richTableList" class="roomTableDiv">
					<table id= "richTable"></table>
				</div>
				
				<div id="rankTableList" class="roomTableDiv">
					<table id="rankTable"></table>
				</div>
				
				<div id="friendTableList" class="roomTableDiv">
					<table id= "friendTable"></table>
				</div>
				</div> 
				</div>	
			 <div id="globalChat" style="float:left;height:20%;width:20%">
						
                        <form onsubmit="controller.chatGlobal(event);">
							<div id= "messageInputGlobal" style="background-color:grey; font-size:11px; color:white; overflow: scroll;height:400px;width:220px"></div>
							<br/>
                            <input id="inputGlobal" type="text">
                            <button class="button" id="sendGlobalButton" type="submit">Gửi</button>
                        </form>
             </div>
			 
			<div style= "width:54%; float:left;">
                <div id="roomTableDiv" class="roomTableDiv" >
                    <table id="roomTable"></table>
                </div>
				<br/>
                <div id="roomControlDiv" >
                    <button class="button" id="createRoomButton" onclick="addRoom();">TẠO PHÒNG CHƠI</button>
                    <button class="button" id="refreshRoomButton" onclick="controller.refreshRoom();">CẬP NHẬT PHÒNG CHƠI</button>
                </div>
			</div>
				
			</div>
            </div>
			
			
            <div id="roomDiv">
                <div id="leftBoardDiv">
                    <div id="user1Div"></div>
                    <div id="timerDiv">
						<div class="mask"></div>
					</div>
                    <div id ="user2Div"></div>
                </div>
                <div id="chessBoardDiv"></div>
                <div id="rightBoardDiv">
                    <div id="roomInfoDiv"></div>
					<br/><br/><br/>
                    <div id="messagesDiv" style="background-color:grey; font-size:11px; color:white; overflow: scroll;height:400px;width:240px"></div>
                    <div id="typeDiv">
                        <form onsubmit="controller.chatInRoom(event)">
                            <input id="messageInput" type="text">
                            <button class="button" id="sendButton" type="submit">Gửi</button>
                        </form>
                    </div>
                </div>
            </div>>
        </div>
		
		
        <div id="footer">

        </div>
          <div id="passwordDialog" class="dialog">
            <form id="passForm">
                <label>Password: </label>
                <input type="text" id="pass">
            </form>
        </div>
		
		   <div id="requestsDialog">
            <table id="requestsTable">
            </table>
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
                <textarea type="text" id="content" name="content" rows="8" cols="5"></textarea><br/>

            </form>
        </div>
		
		<div id="inforDialog" class="dialog">
				<ul class="tabs">
					<li><a href="#viewInfor">Thông tin cá nhân</a></li>
				</ul>
				<div class="tabcontents">
				<div id="viewInfor">
				<table id="info-table" width="500" border="0" cellspacing="20">
				<tr>
					<td> Tên đầy đủ</td>
					<td  height="50" colspan="2"><input style="width:300px;" type="text" class="form-control" id="user_name" placeholder="" required></td>
					</tr>
				<tr>
					<td> Giới tính</td>
					<td  height="50" colspan="2"><input style="width:300px;" type="text" class="form-control" id="user_gender" placeholder="" required></td>
				</tr>
				<tr>
					<td>Email đăng kí</td>
					<td   height="50" colspan="2"><input style="width:300px;" type="text" class="form-control"  id="user_email" placeholder="" required></td>
				</tr>
				<tr>
					<td>Số xu hiện có: </td>
					<td  height="50" colspan="2" id="user_coin"></td>
				</tr>
				<tr>
					<td>Xếp hạng: </td>
					<td  height="50" id="user_rank" colspan="2"></td>
				</tr>
				<tr>
					<td>Số điện thoại: </td>
					<td  height="50" colspan="2"><input  style="width:200px;" type="text" class="form-control"  id="user_tel" placeholder="" required></td>
				</tr>
				<tr>
					<td>Địa chỉ: </td>
					<td  height="50" colspan="2"><input  style="width:200px;" type="text" class="form-control"  id="user_addr" placeholder="" required></td>
				</tr>
				</table>
				</div>
				</div> 
        </div>
		
        <div id="messageDialog"></div>
		
		<div id= "helloDialog">
		 <label style="padding-left:9em; font-size:20px; color:red; font-weight:bold">GIỚI THIỆU</label> <br/><br/>
         <div>
		 Đây là hệ thống Game Cờ tướng Online do nhóm phát triển là đội ngũ 5 sinh viên Đại học Bách Khoa Hà Nội.<br/><br/>
		 1 - <b  style="padding-left:1em; font-size:14px; color:green;"><i>Hoàng Trọng Phúc</b></i> <br/>
		 2 - <b  style="padding-left:1em; font-size:14px; color:green;"><i>Nguyễn Tất Nguyên</b></i> <br/>
		 3 - <b  style="padding-left:1em; font-size:14px; color:green;"><i>Nguyễn Khắc Nhất</b></i> <br/>
		 4 - <b  style="padding-left:1em; font-size:14px; color:green;"><i>Hà Quang Ngà</b></i> <br/>
		 5 - <b  style="padding-left:1em; font-size:14px; color:green;"><i>Thân Văn Nghĩa</b></i> <br/><br/><br/>
		 Dưới sự hướng dẫn của thầy giáo  : <b  style="padding-left:1em; font-size:16px; color:orange;"><i> TS.Nguyễn Bình Minh</b></i> <br/><br/>
		 <t/>32 quân cờ và hai đối thủ đối mặt với nhau trên một bàn cờ. Mỗi người đều phải tự tính toán để có được nước cờ thông minh nhất và chiến thắng hiểm hách nhất.<br/>
		 Hãy đăng kí tài khoản và bắt đầu giao lưu và kết bạn với các cờ thủ trên mọi miền đất nước.<br/>
		 <b>Nếu chưa có tài khoản, hãy đăng ký ngay hôm nay!</b>
		 </div><br/>

		</div>
		
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
        <!--chứa các chat box-->
        <div id="chatboxs"></div>
        <!--chat bõ mẫu-->
        <div id="chatbox-template" class="chatbox">  <!--id trùng với tên user+chatbox -->
            <div class="chatbox-header">
                <div class="chatbox-name"></div>
                <img class="close-icon" src="imgs/close-icon.png">
            </div>
            <div class="chatbox-message"></div>
            <form>
                <input type="text" class="chatbox-input">
            </form>
        </div>
    </body>
</html>