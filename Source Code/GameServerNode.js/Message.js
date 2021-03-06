Game = require("./Chess.js");
Room = require('./Room.js');

function Messaging() {};

Messaging.prototype.sendEventToAllPlayers = function(event, message, io, player) {
	for(var i = 0; i < player.length; i++){
		io.sockets.socket(player[i].id).emit(event, message);
	}
};

Messaging.prototype.sendEventToAllPlayersButPlayer = function(event,message,io,players,player) {
	for(var i = 0; i < players.length; i++) {
		if(players[i].id != player.id) {
			io.sockets.socket(players[i].id).emit(event, message);
		}
	}	
};

Messaging.prototype.sendEventToAPlayer = function(event,message,io,players,player) {
	for(var i = 0; i < players.length; i++) {
		if(players[i].id == player.id) {
			io.sockets.socket(players[i].id).emit(event, message);
		}
	}	
};

Messaging.prototype.createSampleRooms = function(amount) {
	var roomList = [];
	for(var i = 0; i < amount; i++){
		var room = new Room(1);
		if((i%2) !== 0){
		room.boss = "hp";
		room.name = "Test Table" + (i + 1);
		room.status = 0;
		room.countPlaying = 2;
		room.matchLimit = 5;
		room.coin = 1000;}
		else {
		room.boss = "khacnhat";
		room.name = "Table Lock" + (i + 1);
		room.password = "123";
		room.status = 0;
		room.countPlaying = 1;
		room.matchLimit = 3;
		room.coin = 1500;}
		roomList.push(room);
	}
	
	return roomList;
};

Messaging.prototype.createRoom = function(amount) {}

module.exports = Messaging;