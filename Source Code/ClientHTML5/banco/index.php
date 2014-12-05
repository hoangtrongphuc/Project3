<!DOCTYPE html>
<html>
    <head>
        <title>Offline Chinese Chess</title>
        <meta charset="UTF-8">
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/socket.io.js"></script>
        <script type="text/javascript" src="js/chinese_chess.js"></script>
        <link title="text/css" href="css/chinese_chess.css" rel="stylesheet"/>
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
                
				$(window).on("navigate", function (event, data) {
				var direction = data.state.direction;
				if (direction == 'back') {
					if(document.location.hash==="#listRoomDiv"){
					  $.ajax({
					url : "http://localhost:8080/rest/admin/index.php?api=logout",
					type : "post",
					dataType : "json",
					data: "user_id="+$.cookie("cookie_id"),
					async : false,
					success: function(e){},
					error : function(err){}
						});
					var cookies = $.cookie();
					for(var cookie in cookies) {
						$.removeCookie(cookie);
							}
					}
					
					}
				if (direction == 'forward') {
    // do something else
					}
				});

                $("#newRoomDialog").dialog({
                    autoOpen: false, 
                    buttons: {
                        "Hủy": function(){
                            $("#newRoomDialog").dialog("close");
                        },
                        "Tạo": function(){
                            var ob = {};
                            ob.name = $("#roomName").val();
                            ob.match = $("#roomMatch").val();
                            ob.coin = $("#roomCoin").val();
                            ob.pass = $("#roomPass").val();
                            controller.addRoom(ob);
                            $("#newRoomDialog").dialog("close");
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
            function onUnload(){
                if(document.location.hash==="#roomDiv"){
                    controller.leavePage();
                }
				
            }
            function onBeforeUnload(){
                if(document.location.hash==="#roomDiv"){
                    return "Nếu bạn rời đi, phòng chơi sẽ bị hủy. Bạn có chắc chắn muốn rời khỏi trang?";
                }
				else if(document.location.hash==="#listRoomDiv"){
                    
                }
            }
        </script>
    </head>
    <body onhashchange="controller.onHashChange()" onload="controller.onHashChange()">
        <div id="bodyDiv">     
            <div id="listRoomDiv">
             
                <div id="roomTableDiv">
                    <table id="roomTable"></table>
                </div>
                <div id="roomControlDiv">
                    <button class="button" id="createRoomButton" onclick="addRoom();">TẠO PHÒNG</button>
                    <button class="button" id="refreshRoomButton" onclick="controller.refreshRoom();">CẬP NHẬT DANH SÁCH</button>
                </div>
            </div>
            <div id="roomDiv">
                <div id="leftBoardDiv">
                    <div id="user1Div"></div>
                    <div id="timerDiv" class="timer"></div>
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
            <form id="newRoomForm">
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
        <div id="messageDialog"></div>
    </body>
</html>
