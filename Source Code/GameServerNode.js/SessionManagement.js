

function SessionManagement()
{
	this.sessions = [];
	this.token = []
}

SessionManagement.prototype.indexOf = function(sessionId) {
    for(var i in this.sessions) {
        if(this.sessions[i].sessionId == sessionId)
            return i;
    }
    return null;
}

SessionManagement.prototype.checkStatus = function(tokenKey) {
	    for(var i in this.token) {
        if(this.token[i] == tokenKey)
            return true;
    }
    return false;
}

SessionManagement.prototype.addToken = function(tokenKey) {
        this.token.push(tokenKey);
}

SessionManagement.prototype.removeToken = function(tokenKey) {
		var index = this.token.indexOf(tokenKey);
        this.token.splice(index,1);
}

SessionManagement.prototype.indexOfUser = function(userId) {
    for(var i in this.sessions) {
        if(this.sessions[i].userId === userId)
            return i;
    }
    return null;
}
  
SessionManagement.prototype.addUser = function(sessionData) {
    this.sessions.push(sessionData);
}
  
SessionManagement.prototype.removeUser = function(sessionId) {
    var index = this.indexOf(sessionId);
    if(index != null) {
        this.sessions.splice(index, 1);
    } else {
        return null;
    }
}

SessionManagement.prototype.removeByUserId = function(userId) {
    var index = this.indexOf(userId);
    if(index != null) {
        this.sessions.splice(index, 1);
    } else {
        return null;
    }
}
  
SessionManagement.prototype.getSessionById = function(userId) {
    var index = this.indexOfUser(userId);
    if(index != null) {
        return this.sessions[index];
    } else {
        return null;
    }
}

SessionManagement.prototype.checkUserSession = function(sessionData) {
	for(var i in this.sessions)
	{
		if(this.sessions[i].sessionId === sessionData.sessionId) return true;
	}
	return false;
}

SessionManagement.prototype.getSessionByUserId = function(userId) {
    var index = this.indexOfUser(userId);
    if(index != null) {
        return this.sessions[index];
    } else {
        return null;
    }
}

SessionManagement.prototype.getSessionByUsername = function(username) {
    for(var i in this.sessions) {
        if(this.sessions[i].username === username)
            return i;
    }
    return null;
}

SessionManagement.prototype.updateUserLeave = function(userId){
	for(var i in this.sessions)
	{
		if(this.sessions[i].sessionId === userId) 
		{
			this.sessions[i].leaveRoom();
		}
	}
}

SessionManagement.prototype.updateUser = function(sessionData){
	for(var i in this.sessions)
	{
		if(this.sessions[i].sessionId === sessionData.sessionId) 
		{
			this.sessions[i].roomID = sessionData.roomID;
			this.sessions[i].status = sessionData.status; // 0 - rảnh rỗi, 1 - trong phòng chơi, 2 - sẵn sàng, 3 - đang chơi.
			this.sessions[i].turnFinished = sessionData.turnFinished;
		}
	}
}


SessionManagement.prototype.updateUserJoin = function(userId, roomID){
	for(var i in this.sessions)
	{
		if(this.sessions[i].userId === userId) 
		{
			this.sessions[i].joinRoom(roomID);
		}
	}
}

module.exports = SessionManagement;