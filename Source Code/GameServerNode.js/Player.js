function Player(playerID,sessionID,username) {
	this.sessionId = sessionID;
	this.userId = playerID;
	this.username = username;
	this.roomID = -1;
	this.status = 0; // 0 - rảnh rỗi, 1 - trong phòng chơi, 2 - sẵn sàng, 3 - đang chơi.
	this.turnFinished = "";
};

Player.prototype.setName = function(name) {
	this.username = name;
};

Player.prototype.joinRoom = function(roomID){
	this.roomID = roomID;
	this.status = 1;
}

Player.prototype.leaveRoom = function(){
	this.roomID = -1;
	this.status = 0;
}

Player.prototype.getName = function() {
	return this.username;
};

Player.prototype.setRoomID = function(roomID) {
	this.roomID = roomID;
};

Player.prototype.getRoomID = function() {
	return this.roomID;
};


Player.prototype.setStatus = function(status){
	this.status = status;
};

Player.prototype.isAvailable = function(){
	return this.status === 0;
};

Player.prototype.isInRoom = function(){
	return this.status === 1;
};

Player.prototype.isPlaying = function(){
	return this.status === 2;
};

module.exports = Player;