

function SessionManagement()
{
	var sessions = [];
}

SessionManagement.prototype.indexOf = function(sessionId) {
    for(var i in sessions) {
        if(sessions[i].sessionId == sessionId)
            return i;
    }
    return null;
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