var socket = require('socket.io');

var http = require("http");
var server = http.createServer();
var io = socket.listen(server);
server.listen(8888);
var room = [];
var room1  = new Object();
room1.x = 1;
room1.y = 2;

var room2  = new Object();
room2.x = 3;
room2.y = 4;

room.push(room1);
room.push(room2);

io.sockets.on('connection', function (socket) {
		console.log("user");
		socket.emit('res',[{x:room2.x},{y:room2.y}]);
		socket.emit('log',"đăng nhập");
});