var socket = require('socket.io');
var Chess = require('./Chess.js');
var Player = require("./Player.js");
var Message = require('./Message.js');
var Room = require('./Room.js');
var SessionManagement = require('./SessionManagement.js');

var http = require("http");
var server = http.createServer();
var io = socket.listen(server);
server.listen(8888);

var message = new Message();
var sessionManager = new SessionManagement();
var firstRound = 1;
var roomList = [];
var token = [];
roomList = message.createSampleRooms(5);

io.sockets.on('connection', function (socket) {

  socket.on('connectToServer',function(data) {
    var sess = new Player(socket.id,data.token,data.username);
	if(sessionMagager.checkStatus(sess))
	{
		sessionManager.addUser(sess);
		io.sockets.emit("logging", {message: data.username + " đã đăng nhập."});
		socket.emit("roomList",roomList);
	}
	else 
	{
		socket.emit('err',"1");
	}
  });

  socket.on('addRoom', function(data){
     var room = new Room(data.name);
	 room.matchLimit = data.match;
	 room.coin = data.coin;
	 room.boss = data.sessionId;
	 var player = sessionManager.getSessionByUserId(data.userId);
	 player.joinRoom(room.ID);
	 sessionManager.updateUser(player);
	 room.players.push(player);
	 roomList.push(room);
	 
	 io.sockets.emit("roomList",roomList);
     socket.emit('roomInfor',room);
	 socket.join(room.ID);
 });
 
   socket.on('leaveRoom', function(data){
	 var player = sessionManager.getSessionByUserId(data.sessionId);
	 for(var i in roomList)
	 {
		if(roomList[i].ID == player.roomID && roomList[i].boss != player.sessionId) 
		{
			roomList[i].removePlayer(player);
			roomList[i].resetRoom();
			sessionManager.updateUserLeave(player.sessionId);
			socket.leave(room.ID);
			socket.emit("roomList",roomList);
			io.to(room.ID).emit("roomInfor",roomList[i]);
		}
		else if(roomList[i].ID == player.roomID && roomList[i].boss == player.sessionId)
		{
		for(var k in roomList[i].player)
			{
				sessionManager.updateUserLeave(roomList[i].players[k].sessionId);
			}
		var clients = io.sockets.clients(roomList.ID); // all users from room `room`
		for(var t in clients)
			{
					clients[t].leave(roomList.ID)
			}
			roomList.remove(i);
		}
		socket.emit("roomList",roomList);
	 }
	 
 });
 
   socket.on('joinRoom', function(data){
     var player = sessionManager.getSessionByUserId(data.sessionId);
	 var check = 0;
	 for(var i in roomList)
	 {
		if(roomList[i].ID == data.roomID && roomList[i].countPlaying < 2 && player.status == 0) 
		{
		if(player.roomID == -1)
		{
			sessionManager.updateUserJoin(player.sessionId,player);
			roomList[i].addPlayer(player);
			socket.join(roomList[i].ID);
			check = 1;
		}
		}
	 }
	 if(check == 0) socket.emit('err',"2");
     else
	 { 
	 io.to(room.ID).emit("roomInfor",room);
	 }
 });
 
   socket.on('refreshRoom', function(){
	socket.emit('roomList',roomList);
 });
 
   socket.on('activeToken', function(data)){
   sessionManager.addToken(data.tonkenKey);
 });
 
   socket.on('readyToPlay', function(data){
    var player = sessionManager.getSessionByUserId(socket.id);
    for(var k in roomList)
	 {
		if(roomList[k].ID == player.roomID )
		{
			if(roomList[k].status == 0)
			 {
			 roomList[k].status = 1;
			 player.status = 2;
			 sessionManger.updateUser(player);
			 io.to(room.ID).emit("roomInfor",room);
			 break;
			 }
			else if(roomList[k].status == 1)
			{
			 roomList[k].status = 2;
			 roomList[k].turn = roomList[k].countMatch%2;
			 roomList[k].color = roomList[k].countMatch%2;
			 player.status = 3;
			 sessionManger.updateUser(player);
			 io.to(room.ID).emit("roomInfor",room);
			 break;
			}
		}
	 }   
 });
 
   socket.on('playGame', function(data){ 
      var errorFlag = false;
      var player = sessionManager.getSessionById(socket.id);
      for(var k in roomList)
		{
		if(roomList[k].ID == player.roomID )
			{
				var res = roomList[k].updateTable(data.id1,data.id2);
				if(res == -3) io.to(room.ID).emit('err',"Fail");
			}
		}
});


  socket.on("disconnect", function() {
    var player = sessionManager.getSessionById(socket.id);
    if (player && player.status >= 1) { 
      //Remove from table
       for(var k in roomList)
			{
				if(roomList[k].ID == player.roomID && roomList[k].boss != player.sessionId)
				{
					roomList[k].removePlayer(player);
					roomList[k].resetRoom();
					sessionManager.removeUser(player.sessionId);
					io.to(room.ID).emit("roomInfor", roomList[k]);
					io.sockets.emit("logging", {message: player.username + " đã đăng xuất."});
				}
				else if(roomList[k].ID == player.roomID && roomList[k].boss == player.sessionId)
				{
					for(var k in roomList[k].player)
					{
						sessionManager.updateUserLeave(roomList[i].players[k].sessionId);
					}
					sessionManager.removeUser(player.sessionId);
					var clients = io.sockets.clients(roomList.ID); // all users from room `room`
					for(var t in clients)
					{
						clients[t].leave(roomList.ID)
					}
					roomList.remove(k);
					socket.broadcast.emit("roomList",roomList);
					io.sockets.emit("logging", {message: player.username + " đã đăng xuất."});
				}
			}
     
    }
		sessionManager.removeToken(player.sessionId);
  });
});//end of socket.on