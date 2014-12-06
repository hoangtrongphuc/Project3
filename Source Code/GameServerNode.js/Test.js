var socket = require('socket.io');

var http = require("http");
var server = http.createServer();
var io = socket.listen(server);
server.listen(8888);


io.sockets.on('connection', function (socket) {
		console.log("user");
	
});