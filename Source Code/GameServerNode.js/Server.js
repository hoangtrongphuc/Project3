var socket = require('socket.io');
var Chess = require('./Chess.js');
var Player = require("./Player.js");
var Message = require('./Message.js');
var Room = require('./Room.js');
var SessionManagement = require('./SessionManagement.js');

var http = require("http");
var express = require("express");
var app = express();


var server = http.createServer(app);
server.listen(8888);
var io = socket.listen(server);
io.set("log level", 1);

var message = new Message();
var sessionManager = new SessionManagement();
var firstRound = 1;
var roomList = [];

roomList = message.createSampleRooms(5);

io.sockets.on('connection', function (socket) {

  socket.on('connectToServer',function(data) {
    var sess = new Player(socket.id,data.token,username);
	if(sessionMagager.checkStatus(sess))
	{
		sessionManager.addUser(sess);
		io.sockets.emit("logging", {message: data.name + " has connected."});
		socket.emit("roomList",roomList);
	}
	else 
	{
		socket.send("Fail!! Reconnect Now!!");
	}
  });

  socket.on('addRoom', function(data){
     var room = new Room(data.name);
	 room.matchLimit = data.match;
	 room.coin = data.coin;
	 room.boss = data.sessionId;
	 var player = sessionManager.getSessionByUserId(data.userId);
	 player.joinRoom(room.ID);
	 room.players.push(player);
	 roomList.push(room);
	 
	 io.sockets.emit("roomList",roomList);
     io.sockets.emit("logging", {message: player.name + " has connected to room: " + room.name + "."});
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
		}
		else if(roomList[i].ID == player.roomID && roomList[i].boss == player.sessionId)
		{
		for(var k in roomList[i].player)
			sessionManager.updateUserLeave(roomList[i].players[k].sessionId);
			roomList.remove(i);
		}
	 }
	
	 socket.emit("roomList",roomList);
     io.sockets.emit("logging", {message: player.name + " come back lobby Game " });
	 socket.leave(room.ID);
	 io.to(room.ID).emit("roomInfor",room);
 });
 
   socket.on('joinRoom', function(data){
     var player = sessionManager.getSessionByUserId(data.sessionId);
	 for(var i in roomList)
	 {
		if(roomList[i].ID == player.roomID && roomList[i].countPlaying < 2) 
		{
			sessionManager.updateUserJoin(player.sessionId,player);
		}
		else if(roomList[i].ID == player.roomID && roomList[i].boss == player.sessionId)
		{
		for(var k in roomList[i].player)
			sessionManager.updateUserLeave(roomList[i].players[k].sessionId);
			roomList.remove(i);
		}
	 }
	
	 socket.emit("roomList",roomList);
     io.sockets.emit("logging", {message: player.name + " come back lobby Game " });
	 socket.leave(room.ID);
	 io.to(room.ID).emit("roomInfor",room);
 });
 
   socket.on('refreshRoom', function(data){
  
 });
 
   socket.on('readyToPlay', function(data){
   console.log("Ready to play called");
    var player = room.getPlayer(socket.id);
    var table = room.getTable(data.tableID);
    player.status = "playing";
    table.readyToPlayCounter++;
    var randomNumber = Math.floor(Math.random() * table.playerLimit);
    if (table.readyToPlayCounter === table.playerLimit) {
      var firstCardOnTable = table.cardsOnTable = table.gameObj.playFirstCardToTable(table.pack); //assign first card on table
      table.status = "unavailable"; //set the table status to unavailable
      for (var i = 0; i < table.players.length; i++) { //go through the players array (contains all players sitting at a table)
        table.players[i].hand = table.gameObj.drawCard(table.pack, 5, "", 1); //assign initial 5 cards to players
        var startingPlayerID = table.playersID[randomNumber]; //get the ID of the randomly selected player who will start
        if (table.players[i].id === startingPlayerID) { //this player will start the turn
          table.players[i].turnFinished = false;
          console.log(table.players[i].name + " starts the game.");
          io.sockets.socket(table.players[i].id).emit("play", { hand: table.players[i].hand }); //send the cards in hands to player
          io.sockets.socket(table.players[i].id).emit("turn", { myturn: true }); //send the turn-signal to player
          io.sockets.socket(table.players[i].id).emit("ready", { ready: true }); //send the 'ready' signal
          if (table.gameObj.isActionCard(firstCardOnTable)) { //Is the first card on the table an action card?
            table.actionCard = true; //we are setting the action card flag to true -- this is required as the preliminary check is going to use this
          }
          io.sockets.socket(table.players[i].id).emit("cardInHandCount", {cardsInHand: table.players[i].hand.length});
        } else {
          table.players[i].turnFinished = true;
          console.log(table.players[i].name + " will not start the game.");
          io.sockets.socket(table.players[i].id).emit("play", { hand: table.players[i].hand }); //send the card in hands to player
          io.sockets.socket(table.players[i].id).emit("turn", { myturn: false }); //send the turn-signal to player
          io.sockets.socket(table.players[i].id).emit("ready", { ready: true }); //send the 'ready' signal
          io.sockets.socket(table.players[i].id).emit("cardInHandCount", {cardsInHand: table.players[i].hand.length});
        }
      }
      //sends the cards to the table.
      messaging.sendEventToAllPlayers('updateCardsOnTable', {cardsOnTable: table.cardsOnTable, lastCardOnTable: table.cardsOnTable}, io, table.players);
      io.sockets.emit('updatePackCount', {packCount: table.pack.length});
    }
 });
 
   socket.on('playGame', function(data){
     /*
      server needs to check:
      - if it's the player's turn
      - if the played card is in the owner's hand
      - if the played card's index, matches the server side index value
      - if the played card is valid to play
      */
      var errorFlag = false;
      var player = room.getPlayer(socket.id);
      var table = room.getTable(data.tableID);
      var last = table.gameObj.lastCardOnTable(table.cardsOnTable); //last card on Table

      if (!player.turnFinished) {
        var playedCard = data.playedCard;
        var index = data.index; //from client
        var serverIndex = utils.indexOf(player.hand, data.playedCard);

        console.log("index => " + index + " | serverindex ==> " + serverIndex);

        if (index == serverIndex) {
          errorFlag = false;
        } else {
          errorFlag = true;
          playedCard = null;
          messaging.sendEventToAPlayer("logging", {message: "Index mismatch - you have altered with the code."}, io, table.players, player);
          socket.emit("play", {hand: player.hand});
        }

        if (utils.indexOf(player.hand, data.playedCard) > -1) {
          errorFlag = false;
          playedCard = data.playedCard; //overwrite playedCard
        } else {
          errorFlag = true;
          playedCard = null;
          messaging.sendEventToAPlayer("logging", {message: "The card is not in your hand."}, io, table.players, player);
          socket.emit("play", {hand: player.hand});
        }
        if (!errorFlag) {
          if (table.actionCard) { //if the action card varialbe is already set ...
            if (table.penalisingActionCard) {
              if (!table.gameObj.isPenalisingActionCardPlayable(playedCard, last)) {
                messaging.sendEventToAPlayer("logging", {message: "The selected card cannot be played - please read the rules."}, io, table.players, player); 
              } else {
                  console.log("Penalising action card is playable");
                  if (parseInt(playedCard) === 2) { //if there's a penalising action card, the player can only play another penalising action card.
                    console.log("if player plays a 2 we append the forced card limit");
                    //we are going to hide the option
                    socket.emit("playOption", { value: false }); //OPTION - FALSE
                    table.actionCard = true;
                    table.penalisingActionCard = true;
                  }
                table.gameObj.playCard(index, player.hand, table.cardsOnTable);
                messaging.sendEventToAllPlayers('updateCardsOnTable', {cardsOnTable: table.cardsOnTable, lastCardOnTable: playedCard}, io, table.players);
                io.sockets.emit("logging", {message: player.name + " plays a card: " + playedCard});
                table.progressRound(player); //end of turn
                //notify frontend
                messaging.sendEventToAPlayer("turn", {myturn: false}, io, table.players, player);
                messaging.sendEventToAllPlayersButPlayer("turn", {myturn: true}, io, table.players, player);
                messaging.sendEventToAllPlayersButPlayer("cardInHandCount", {cardsInHand: player.hand.length}, io, table.players, player);
                var winner = table.gameObj.isWinning(player.hand);
                if (!winner) {
                  socket.emit("play", {hand: player.hand});
                } else {
                //game is finished
                socket.emit("play", {hand: player.hand});
                messaging.sendEventToAPlayer("turn", {won: "yes"}, io, table.players, player);
                messaging.sendEventToAllPlayersButPlayer("turn", {won: "no"}, io, table.players, player);
                socket.emit("gameover", {gameover: true});
                io.sockets.emit("logging", {message: player.name + " is the WINNER!"});
                }
              }
            } //end of penalising action card
            if (table.gameObj.isActionCard(playedCard)) {
                    socket.emit("playOption", { value: false }); //OPTION - FALSE
                    table.actionCard = true;
                    table.penalisingActionCard = true;
          }

          }
          else { //no action card variable is set at the moment
            var requestMade = false;
            if (!table.gameObj.isCardPlayable(playedCard, last)) {
              messaging.sendEventToAPlayer("logging", {message: "The selected card cannot be played - please read the rules."}, io, table.players, player); 
            } else {
              if (parseInt(playedCard) === 2) { //if player plays a 2 we add the right flags
                console.log("if player plays a 2 we append the forced card limit");
                table.actionCard = true;
                table.penalisingActionCard = true;
              }
              if (parseInt(playedCard) === 1) {
                var option = "suite"
                table.actionCard = true;
                table.requestActionCard = true;
                console.log("in here");
                messaging.sendEventToAPlayer("logging", {message: "YESSSSSSS"}, io, table.players, player);
                messaging.sendEventToAPlayer("showRequestCardDialog", {option: option}, io, table.players, player);

              }

              /*if (parseInt(playedCard) === 13) {
                table.actionCard = true;
                table.requestActionCard = true;
              } */
              table.gameObj.playCard(index, player.hand, table.cardsOnTable);
              messaging.sendEventToAllPlayers('updateCardsOnTable', {cardsOnTable: table.cardsOnTable, lastCardOnTable: playedCard}, io, table.players);
              io.sockets.emit("logging", {message: player.name + " plays a card: " + playedCard});
              table.progressRound(player); //end of turn
              //notify frontend
              messaging.sendEventToAPlayer("turn", {myturn: false}, io, table.players, player);
              messaging.sendEventToAllPlayersButPlayer("turn", {myturn: true}, io, table.players, player);
              messaging.sendEventToAllPlayersButPlayer("cardInHandCount", {cardsInHand: player.hand.length}, io, table.players, player);
              var winner = table.gameObj.isWinning(player.hand);
              if (!winner) {
                socket.emit("play", {hand: player.hand});
              } else {
              //game is finished
              socket.emit("play", {hand: player.hand});
              messaging.sendEventToAPlayer("turn", {won: "yes"}, io, table.players, player);
              messaging.sendEventToAllPlayersButPlayer("turn", {won: "no"}, io, table.players, player);
              socket.emit("gameover", {gameover: true});
              io.sockets.emit("logging", {message: player.name + " is the WINNER!"});
              }
            }
          } 
        } else {
            io.sockets.emit("logging", {message: "Error flag is TRUE, something went wrong"});
        }
      } else { //end of turn
        messaging.sendEventToAPlayer("logging", {message: "It's your opponent's turn."}, io, table.players, player);
    }
 });


  socket.on("disconnect", function() {
    var player = room.getPlayer(socket.id);
    if (player && player.status === "intable") { //make sure that player either exists or if player was in table (we don't want to remove players)
      //Remove from table
      var table = room.getTable(player.tableID);
      table.removePlayer(player);
      table.status = "available";
      player.status = "available";
      io.sockets.emit("logging", {message: player.name + " has left the table."});
    } 
  });


});//end of socket.on