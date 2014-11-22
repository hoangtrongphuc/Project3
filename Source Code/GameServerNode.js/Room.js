var Chess = require("./Chess.js");

function Room(name){
	this.players = [];
	ID++;
	this.countPlaying = 1; // số người đang chơi
	this.countMatch = 0; // số trận đã đấu
	this.name = name;
	this.matchLimit = 1;
	this.coin = 0;
	this.status = 0;
	this.boss = 0;
	this.table = new Chess();
	this.turn = 0; // lượt đi : 0 - trắng, 1 - đen.
	this.color = 0; // 0 - boss trắng, khách đen / 1 ngược lại.
};

Room.ID = 0;

Room.prototype.resetRoom = function(){
	this.countPlaying = 1; 
	this.countMatch = 0; 
	this.status = 0;
	this.table.resetBoard();
	this.turn = 0; 
	this.color = 0;
}

Room.prototype.addPlayer = function(player) {
	this.players.push(player);
	this.countPlaying++;
};

Room.prototype.removePlayer = function(player) {
	var playerIndex = -1;
	for(var i = 0; i < this.players.length; i++){
		if(this.players[i].id == player.userId){
			playerIndex = i;
			break;
		}
	}
	this.players.remove(playerIndex);
	this.countPlaying--;
};

Room.prototype.resetTable = function() {
	this.tables.resetBoard();
};

Room.prototype.getPlayer = function(playerId) {
	var player = null;
	for(var i = 0; i < this.players.length; i++) {
		if(this.players[i].id == playerId) {
			player = this.players[i];
			break;
		}
	}
	return player;
};

Room.prototype.updateTable = function(id1,id2)
{
	if(this.table.isValidMove(id1,id2))
		{
		this.table.chessMove(id1,id2);
		return this.table.checkStatus();
		}
	else return -3; // fail
}

Room.prototype.getTable = function() 
{
	return table;
};


module.exports = Room;