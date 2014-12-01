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
	var check = sessionManager.checkUserSession(sess);
	if(check == true) 
	{
	socket.emit('err',"7");
	socket.disconnect();
	}
	else 
	{
	if(sessionManager.checkStatus(sess.sessionId))
	{
		sessionManager.addUser(sess);
		//io.sockets.emit("logging", {message: data.username + " đã đăng nhập."});
	  var dup_array = JSON.parse(JSON.stringify(roomList));
		for(var i in dup_array)
		{
		delete dup_array[i].table;
		delete dup_array[i].turn;
		delete dup_array[i].bossWin;
		delete dup_array[i].color;
		}
		socket.emit("roomList",dup_array);
		//sessionManager.removeToken(data.token);
	}
	else 
	{
		socket.emit('err',"1");
	}
	}
  });

  socket.on('addRoom', function(data){
     var room = new Room(data.name);
	 if(data.pass) room.password = data.pass;
	 room.matchLimit = data.match;
	 room.coin = data.coin;
	 var player = sessionManager.getSessionByUserId(socket.id);
	 room.boss = player.username;
	 player.joinRoom(room.ID);
	 sessionManager.updateUser(player);
	 room.players.push(player);
	 roomList.push(room);
	 console.log(room);
	  var dup_array = JSON.parse(JSON.stringify(roomList));
		for(var i in dup_array)
		{
		delete dup_array[i].table;
		delete dup_array[i].turn;
		delete dup_array[i].bossWin;
		delete dup_array[i].color;
		} 
	 console.log(room);
	 socket.emit('added',{message : "tạo phòng thành công"});
	 io.sockets.emit("roomList",dup_array);
     socket.emit('roomInfor',room);
	 socket.join(room.ID);
 });
 
   socket.on('leaveRoom', function(data){
	 var player = sessionManager.getSessionByUserId(socket.id);
	 for(var i in roomList)
	 {
		if(roomList[i].ID === player.roomID && roomList[i].boss !== player.username) 
		{
			player.leaveRoom();
			roomList[i].removePlayer(player);
			roomList[i].resetRoom();
			//sessionManager.updateUserLeave(player.sessionId);
			socket.leave(roomList[i].ID);
			socket.emit('loseGU','');
			io.to(roomList[i].ID).emit("winGU",'');
	  var dup_array = JSON.parse(JSON.stringify(roomList));
		for(var i in dup_array)
		{
		delete dup_array[i].table;
		delete dup_array[i].turn;
		delete dup_array[i].bossWin;
		delete dup_array[i].color;
		}
		socket.emit("roomList",dup_array);
		io.to(roomList[i].ID).emit("roomInfor",roomList[i]);
		}
		else if(roomList[i].ID === player.roomID && roomList[i].boss === player.username)
		{
		for(var k in roomList[i].players)
			{
				//sessionManager.updateUserLeave(roomList[i].players[k].sessionId);
				//player.leaveRoom();
				roomList[i].players[k].leaveRoom();
			}
		for (var socketId in io.nsps['/'].adapter.rooms[roomList[i].ID]) {
			var socketA = io.sockets.connected[socketId];
			socketA.leave(roomList[i].ID);
			}
		roomList.splice(i,1);
		}
	  var dup_array = JSON.parse(JSON.stringify(roomList));
		for(var v in dup_array)
		{
		delete dup_array[v].table;
		delete dup_array[v].turn;
		delete dup_array[v].bossWin;
		delete dup_array[v].color;
		}
		socket.emit("roomList",dup_array);
	 }
	 
 });
 
   socket.on('joinRoom', function(data){
     var player = sessionManager.getSessionByUserId(socket.id);
	 var check = -1;
//	 player.roomID = -1;
	 for(var i in roomList)
	 {
		if(roomList[i].ID == data.roomID && roomList[i].countPlaying < 2 && (data.pass === roomList[i].password || !data.pass) ) 
		{
		if(player.roomID == -1)
		{
			//sessionManager.updateUserJoin(player.sessionId,player);
			player.joinRoom(data.roomID);
			roomList[i].addPlayer(player);
			socket.join(roomList[i].ID);
			check = i;
			if(roomList[i].countPlaying === 2) socket.emit('roomFull','');
		}
		}
	 }
	 if(check < 0) socket.emit('err',"2");
     else
	 { 
	 io.to(roomList[check].ID).emit("roomInfor",roomList[check]);
	 socket.emit('joined','');
	 }
 });
 
   socket.on('refreshRoom', function(){
	  var dup_array = JSON.parse(JSON.stringify(roomList));
		for(var i in dup_array)
		{
		delete dup_array[i].table;
		delete dup_array[i].turn;
		delete dup_array[i].bossWin;
		delete dup_array[i].color;
		}
		socket.emit("roomList",dup_array);
 });
 
   socket.on('activeToken', function(data){
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
		//	 sessionManger.updateUser(player);
			 io.to(roomList[k].ID).emit("roomInfor",roomList[k]);
			 break;
			 }
			else if(roomList[k].status == 1)
			{
			 roomList[k].status = 2;
			 roomList[k].turn = roomList[k].countMatch%2;
			 roomList[k].color = roomList[k].countMatch%2;
			 player.status = 3;
		//	 sessionManger.updateUser(player);
			 io.to(roomList[k].ID).emit("roomInfor",roomList[k]);
			 			 console.log(roomList[k]);
			 io.to(roomList[k].ID).emit('boardInfo',{turn : player.username, board : roomList[k].table.board});
			 break;
			}
		}
	 }   
 });
 
   socket.on('move', function(data){ 
      var errorFlag = false;
      var player = sessionManager.getSessionById(socket.id);
      for(var k in roomList)
		{
		if(roomList[k].ID == player.roomID )
			{
				var res = roomList[k].updateTable(data.id1,data.id2);
				if(res == -3) io.to(roomList[k].ID).emit('err',"6");
				else if(res == -1) io.to.(roomList[k].ID).emit
				else io.to(roomList[k].ID).emit('opMove',{id1 : data.id1, id2 : data.id2});
			}
		}
});

socket.on('chatInRoom', function(data){
	var player  = sessionManager.getSessionById(socket.id);
	io.to(player.roomID).emit('chatroommessage',{message : data.message, username : player.username});
});

socket.on('giveUp',function(data){
	var player  = sessionManager.getSessionById(socket.id);
	  for(var i in roomList)
	 {
		if(roomList[i].ID === player.roomID) 
		{
			if(roomList[i].status < 2) {socket.emit('notGiveUp',''); break;}
		    roomList[i].bossWin++;
			if(roomList[i].color == 0) roomList[i].color = 1;
			else roomList[i].color = 0;
			roomList[i].turn = 0;
			roomList[i].countMatch++;
			roomList[i].table = new Chess();
	  var dup_array = JSON.parse(JSON.stringify(roomList));
		for(var i in dup_array)
		{
		delete dup_array[i].table;
		delete dup_array[i].turn;
		delete dup_array[i].bossWin;
		delete dup_array[i].color;
		}
		socket.emit("roomList",dup_array);
			for (var socketId in io.nsps['/'].adapter.rooms[roomList[i].ID]) {
			var socketA = io.sockets.connected[socketId];
			if(socketId === socket.id)
			socketA.emit('loseGU','');
			else socketA.emit('winGU','');
			}
		}
	 }
});


socket.on('chatFriend', function(data){
	var player1  = sessionManager.getSessionByUsername(data.username1);
	var player2  = sessionManager.getSessionByUsername(data.username2);
	message.sendEventToAPlayer('chatmessage',{message : data.message, username : data.username1},io,sessionManager.sessions,player2);
});

  socket.on("disconnect", function() {
    var player = sessionManager.getSessionById(socket.id);
	console.log(socket.id + " dis\n");
    if (player!=null && player.status >= 1) { 
      //Remove from table
       for(var k in roomList)
			{
				if(roomList[k].ID == player.roomID && roomList[k].boss != player.sessionId)
				{
					roomList[k].removePlayer(player);
					roomList[k].resetRoom();
					sessionManager.removeUser(player.sessionId);
					io.to(roomList[k].ID).emit("roomInfor", roomList[k]);
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
	  var dup_array = JSON.parse(JSON.stringify(roomList));
					for(var i in dup_array)
					{
					delete dup_array[i].table;
					delete dup_array[i].turn;
					delete dup_array[i].bossWin;
					delete dup_array[i].color;
					}
					socket.broadcast.emit("roomList",dup_array);
					io.sockets.emit("logging", {message: player.username + " đã đăng xuất."});
				}
			}
    }
	else if(player!=null && player.status == 0)
	{
		sessionManager.removeUser(player.sessionId);
		io.sockets.emit("logging", {message: player.username + " đã đăng xuất."});
	}
		//if(player != null)
		//sessionManager.removeToken(player.sessionId);
  });
});//end of socket.on