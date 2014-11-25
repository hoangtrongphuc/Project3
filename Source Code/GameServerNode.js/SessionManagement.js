

function SessionManagement()
{
	var sessions = [];
	var token = []
}

SessionManagement.prototype.indexOf = function(sessionId) {
    for(var i in sessions) {
        if(sessions[i].sessionId == sessionId)
            return i;
    }
    return null;
}

SessionManagement.prototype.checkStatus = function(tokenKey) {
	    for(var i in token) {
        if(token[i] == tokenKey)
            return true;
    }
    return false;
}

SessionManagement.prototype.addToken = function(tokenKey) {
        token.push(tokenKey);
}

SessionManagement.prototype.removeToken = function(tokenKey) {
        token.remove(tokenKey);
}
SessionManagement.prototype.indexOfUser = function(userId) {
    for(var i in sessions) {
        if(sessions[i].userId == userId)
            return i;
    }
    return null;
}
  
SessionManagement.prototype.addUser = function(sessionData) {
    sessions.push(sessionData);
}
  
SessionManagement.prototype.removeUser = function(sessionId) {
    var index = this.indexOf(sessionId);
    if(index != null) {
        sessions.splice(index, 1);
    } else {
        return null;
    }
}

SessionManagement.prototype.removeByUserId = function(userId) {
    var index = this.indexOf(userId);
    if(index != null) {
        sessions.splice(index, 1);
    } else {
        return null;
    }
}
  
SessionManagement.prototype.getSessionById = function(userId) {
    var index = this.indexOfUser(userId);
    if(index != null) {
        return sessions[index];
    } else {
        return null;
    }
}

SessionManagement.prototype.checkUserSession = function(sessionData) {
	for(var i in sessions)
	{
		if(sessions[i].sessionId == sessionData.sessionId) return true;
	}
	return false;
}

SessionManagement.prototype.getSessionByUserId = function(userId) {
    var index = this.indexOfUser(userId);
    if(index != null) {
        return sessions[index];
    } else {
        return null;
    }
}


SessionManagment.prototype.updateUserLeave = function(userId){
	for(var i in sessions)
	{
		if(sessions[i].sessionId == userId) 
		{
			sessions[i].leaveRoom();
		}
	}
}

SessionManagment.prototype.updateUser = function(sessionData){
	for(var i in sessions)
	{
		if(sessions[i].sessionId == sessionData.sessionId) 
		{
			sessions[i].roomID = sessionData.roomID;
			sessions[i].status = sessionData.status; // 0 - rảnh rỗi, 1 - trong phòng chơi, 2 - sẵn sàng, 3 - đang chơi.
			sessions[i].turnFinished = sessionData.turnFinished;
		}
	}
}


SessionManagment.prototype.updateUserJoin = function(userId, roomID){
	for(var i in sessions)
	{
		if(sessions[i].sessionId == userId) 
		{
			sessions[i].joinRoom(roomID);
		}
	}
}

module.exports = SessionManagement;