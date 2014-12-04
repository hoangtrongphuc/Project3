/* 
 * Copyright (c) 2014 Nguyen Tat Nguyen
 */
var controller = (function () {
    var token1="kaka", user1="p", token2="xax", user2='n';
    var test_token = token1;
    var test_user = user1;
    var board=[],
        turn,//bằng 0 hoặc 8. 0-đen, 8-đ�?
        myColor,// bằng 0 hoặc 8
        username = getCookie('username'),//tên ngư�?i chơi
        token = getCookie('token'),
        roomInfo,
        haveRoom = false,
        ownRoom,
        roomList=[],
        gameStart = false,
        focusedValidMove=[],
        focused,
        mainDiv,
        controlDiv,
        gameDiv,
        infoCanvas,
        animateCanvas,
        socket,
        connectURL = "localhost:8888",
        giveUpButton,
        leaveRoomButton,
        readyButton,
        nextButton,
        closeRoomButton,
        timer,
        pieceCanvas = [],
        boardCanvas,
        pieceImgs=[[],[]],
        focusImg,
        boardImg,
        validMoveImg,
        winImg,
        loseImg,
        checkImg,
        cellSize,
        boardHeight,
        boardWidth,
        imageCount = 0;//number of image have been loaded
     
    function max(a, b){
        return a>b?a:b;
    }
    function min(a, b){
        return a>b?b:a;
    }
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ')
                c = c.substring(1);
            if (c.indexOf(name) !== -1)
                return c.substring(name.length, c.length);
        }
        return "";
    }
    function lookAt(r, c) {
        return board[r * 9 + c];
    }
    function validMoveGen(id, validMove){
        var piece = board[id];
        if(piece===0) return;//can be delete
        var col = id % 9;
        var row = (id-col) / 9;
        var piece_type = piece&7;
        var piece_color = piece&8;
        switch(piece_type){
            case 1://tướng
                if(piece_color !== myColor){//other player
                    if(row>0){
                        if(lookAt(row-1,col)===0){
                            validMove.push(id, (row-1)*9+col);
                        }else if((lookAt(row-1,col)&8)!==piece_color){
                            validMove.push(id, (row-1)*9+col);
                        }
                    }
                    if(row<2){
                        if(lookAt(row+1,col)===0){
                            validMove.push(id, (row+1)*9+col);
                        }else if((lookAt(row+1,col)&8)!==piece_color){
                            validMove.push(id, (row+1)*9+col);
                        }
                    }
                    if(col>3){
                        if(lookAt(row,col-1)===0){
                            validMove.push(id, row*9+col-1);
                        }else if((lookAt(row,col-1)&8)!==piece_color){
                            validMove.push(id, row*9+col-1);
                        }
                    }
                    if(col<5){
                        if(lookAt(row,col+1)===0){
                            validMove.push(id, row*9+col+1);
                        }else if((lookAt(row,col+1)&8)!==piece_color){
                            validMove.push(id, row*9+col+1);
                        }
                    }
                    //hở mặt tướng
                    for(var i = row+1; i<10; i++){
                        if(lookAt(i,col)!==0){
                            if(lookAt(i,col)===9){
                                validMove.push(id, i*9+col);
                            }
                            break;
                        }
                    }
                }else{//player
                    if(row>7){
                        if(lookAt(row-1,col)===0){
                            validMove.push(id, (row-1)*9+col);
                        }else if((lookAt(row-1,col)&8)!==piece_color){
                            validMove.push(id, (row-1)*9+col);
                        }
                    }
                    if(row<9){
                        if(lookAt(row+1,col)===0){
                            validMove.push(id, (row+1)*9+col);
                        }else if((lookAt(row+1,col)&8)!==piece_color){
                            validMove.push(id, (row+1)*9+col);
                        }
                    }
                    if(col>3){
                        if(lookAt(row,col-1)===0){
                            validMove.push(id, row*9+col-1);
                        }else if((lookAt(row,col-1)&8)!==piece_color){
                            validMove.push(id, row*9+col-1);
                        }
                    }
                    if(col<5){
                        if(lookAt(row,col+1)===0){
                            validMove.push(id, row*9+col+1);
                        }else if((lookAt(row,col+1)&8)!==piece_color){
                            validMove.push(id, row*9+col+1);
                        }
                    }
                    //hở mặt tướng
                    for(var i = row-1; i>=0; i--){
                        if(lookAt(i,col)!==0){
                            if(lookAt(i,col)===1){
                                validMove.push(id, i*9+col);
                            }
                            break;
                        }
                    }
                }
                break;
            case 2://sĩ
                if(piece_color!==myColor){//other player
                    if(row>0 && col>3){
                        if(lookAt(row-1, col-1)===0){
                            validMove.push(id, (row-1)*9+col-1);
                        }else if((lookAt(row-1, col-1)&8) !== piece_color){
                            validMove.push(id, (row-1)*9+col-1);
                        }
                    }
                    if(row<2 && col<5){
                        if(lookAt(row+1, col+1)===0){
                            validMove.push(id, (row+1)*9+col+1);
                        }else if((lookAt(row+1, col+1)&8) !== piece_color){
                            validMove.push(id, (row+1)*9+col+1);
                        }
                    }
                    if(row>0 && col<5){
                        if(lookAt(row-1, col+1)===0){
                            validMove.push(id, (row-1)*9+col+1);
                        }else if((lookAt(row-1, col+1)&8) !== piece_color){
                            validMove.push(id, (row-1)*9+col+1);
                        }
                    }
                    if(row<2 && col>3){
                        if(lookAt(row+1, col-1)===0){
                            validMove.push(id, (row+1)*9+col-1);
                        }else if((lookAt(row+1, col-1)&8) !== piece_color){
                            validMove.push(id, (row+1)*9+col-1);
                        }
                    }
                }else{//player
                    if(row>7 && col>3){
                        if(lookAt(row-1, col-1)===0){
                            validMove.push(id, (row-1)*9+col-1);
                        }else if((lookAt(row-1, col-1)&8) !== piece_color){
                            validMove.push(id, (row-1)*9+col-1);
                        }
                    }
                    if(row<9 && col<5){
                        if(lookAt(row+1, col+1)===0){
                            validMove.push(id, (row+1)*9+col+1);
                        }else if((lookAt(row+1, col+1)&8) !== piece_color){
                            validMove.push(id, (row+1)*9+col+1);
                        }
                    }
                    if(row>7 && col<5){
                        if(lookAt(row-1, col+1)===0){
                            validMove.push(id, (row-1)*9+col+1);
                        }else if((lookAt(row-1, col+1)&8) !== piece_color){
                            validMove.push(id, (row-1)*9+col+1);
                        }
                    }
                    if(row<9 && col>3){
                        if(lookAt(row+1, col-1)===0){
                            validMove.push(id, (row+1)*9+col-1);
                        }else if((lookAt(row+1, col-1)&8) !== piece_color){
                            validMove.push(id, (row+1)*9+col-1);
                        }
                    }
                }
                break;
            case 3://tượng
                if(piece_color !== myColor ){//other plyaer
                    if(row>0 && col>0 && (lookAt(row-1,col-1)===0)){
                        if(lookAt(row-2, col-2)===0){
                            validMove.push(id, (row-2)*9+col-2);
                        }else if((lookAt(row-2, col-2)&8) !== piece_color){
                            validMove.push(id, (row-2)*9+col-2);
                        }
                    }
                    if(row<4 && col<8 && (lookAt(row+1,col+1)===0)){
                        if(lookAt(row+2, col+2)===0){
                            validMove.push(id, (row+2)*9+col+2);
                        }else if((lookAt(row+2, col+2)&8) !== piece_color){
                            validMove.push(id, (row+2)*9+col+2);
                        }
                    }
                    if(row>0 && col<8 && (lookAt(row-1,col+1)===0)){
                        if(lookAt(row-2, col+2)===0){
                            validMove.push(id, (row-2)*9+col+2);
                        }else if((lookAt(row-2, col+2)&8) !== piece_color){
                            validMove.push(id, (row-2)*9+col+2);
                        }
                    }
                    if(row<4&& col>0 && (lookAt(row+1,col-1)===0)){
                        if(lookAt(row+2, col-2)===0){
                            validMove.push(id, (row+2)*9+col-2);
                        }else if((lookAt(row+2, col-2)&8) !== piece_color){
                            validMove.push(id, (row+2)*9+col-2);
                        }
                    }
                }else{//player
                    if(row>5 && col>0 && (lookAt(row-1,col-1)===0)){
                        if(lookAt(row-2, col-2)===0){
                            validMove.push(id, (row-2)*9+col-2);
                        }else if((lookAt(row-2, col-2)&8) !== piece_color){
                            validMove.push(id, (row-2)*9+col-2);
                        }
                    }
                    if(row<9 && col<8 && (lookAt(row+1,col+1)===0)){
                        if(lookAt(row+2, col+2)===0){
                            validMove.push(id, (row+2)*9+col+2);
                        }else if((lookAt(row+2, col+2)&8) !== piece_color){
                            validMove.push(id, (row+2)*9+col+2);
                        }
                    }
                    if(row>5 && col<8 && (lookAt(row-1,col+1)===0)){
                        if(lookAt(row-2, col+2)===0){
                            validMove.push(id, (row-2)*9+col+2);
                        }else if((lookAt(row-2, col+2)&8) !== piece_color){
                            validMove.push(id, (row-2)*9+col+2);
                        }
                    }
                    if(row<9&& col>0 && (lookAt(row+1,col-1)===0)){
                        if(lookAt(row+2, col-2)===0){
                            validMove.push(id, (row+2)*9+col-2);
                        }else if((lookAt(row+2, col-2)&8) !== piece_color){
                            validMove.push(id, (row+2)*9+col-2);
                        }
                    }
                }
                break;
            case 4://xe
                for(var i = col+1; i<9; i++){
                    if(lookAt(row,i)===0){
                        validMove.push(id, row*9+i);
                    }else{ 
                        if((lookAt(row,i)&8) !== piece_color){
                            validMove.push(id, row*9+i);
                        }
                        break;
                    }
                }
                for(var i = col-1; i>=0; i--){
                    if(lookAt(row,i)===0){
                        validMove.push(id, row*9+i);
                    }else{ 
                        if((lookAt(row,i)&8) !== piece_color){
                            validMove.push(id, row*9+i);
                        }
                        break;
                    }
                }
                for(var i = row+1; i<10; i++){
                    if(lookAt(i,col)===0){
                        validMove.push(id, i*9+col);
                    }else{ 
                        if((lookAt(i,col)&8) !== piece_color){
                            validMove.push(id, i*9+col);
                        }
                        break;
                    }
                }
                for(var i = row-1; i>=0; i--){
                    if(lookAt(i,col)===0){
                        validMove.push(id, i*9+col);
                    }else{ 
                        if((lookAt(i,col)&8) !== piece_color){
                            validMove.push(id, i*9+col);
                        }
                        break;
                    }
                }
                break;
            case 5://pháo
                for(var i = col+1; i<9; i++){
                    if(lookAt(row,i)===0){
                        validMove.push(id, row*9+i);
                    }else{
                        for(var j = i+1; j<9; j++){
                            if(lookAt(row,j)!==0){
                                if((lookAt(row,j)&8) !== piece_color){
                                    validMove.push(id, row*9+j);
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
                for(var i = col-1; i>=0; i--){
                    if(lookAt(row,i)===0){
                        validMove.push(id, row*9+i);
                    }else{
                        for(var j = i-1; j>=0; j--){
                            if(lookAt(row,j)!==0){
                                if((lookAt(row,j)&8) !== piece_color){
                                    validMove.push(id, row*9+j);
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
                for(var i = row+1; i<10; i++){
                    if(lookAt(i,col)===0){
                        validMove.push(id, i*9+col);
                    }else{
                        for(var j = i+1; j<10; j++){
                            if(lookAt(j,col)!==0){
                                if((lookAt(j,col)&8) !== piece_color){
                                    validMove.push(id, j*9+col);
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
                for(var i = row-1; i>=0; i--){
                    if(lookAt(i,col)===0){
                        validMove.push(id, i*9+col);
                    }else{
                        for(var j = i-1; j>=0; j--){
                            if(lookAt(j,col)!==0){
                                if((lookAt(j,col)&8) !== piece_color){
                                    validMove.push(id, j*9+col);
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
                break;
            case 6://mã
                if (row > 1 && lookAt(row - 1, col) === 0) {//không bị cản phía trên
                    if (col > 0) {
                        if (lookAt(row - 2, col - 1) === 0) {
                            validMove.push(id, (row - 2) * 9 + col - 1);
                        } else if ((lookAt(row - 2, col - 1) & 8) !== piece_color) {
                            validMove.push(id, (row - 2) * 9 + col - 1);
                        }
                    }
                    if (col < 8) {
                        if (lookAt(row - 2, col + 1) === 0) {
                            validMove.push(id, (row - 2) * 9 + col + 1);
                        } else if ((lookAt(row - 2, col + 1) & 8) !== piece_color) {
                            validMove.push(id, (row - 2) * 9 + col + 1);
                        }
                    }
                }
                if (row < 8 && lookAt(row + 1, col) === 0) {//không bị cản phía dưới
                    if (col > 0) {
                        if (lookAt(row + 2, col - 1) === 0) {
                            validMove.push(id, (row + 2) * 9 + col - 1);
                        } else if ((lookAt(row + 2, col - 1) & 8) !== piece_color) {
                            validMove.push(id, (row + 2) * 9 + col - 1);
                        }
                    }
                    if (col < 8) {
                        if (lookAt(row + 2, col + 1) === 0) {
                            validMove.push(id, (row + 2) * 9 + col + 1);
                        } else if ((lookAt(row + 2, col + 1) & 8) !== piece_color) {
                            validMove.push(id, (row + 2) * 9 + col + 1);
                        }
                    }
                }
                if (col > 1 && lookAt(row, col-1) === 0) {//không bị cản phía trái
                    if (row > 0) {
                        if (lookAt(row - 1, col - 2) === 0) {
                            validMove.push(id, (row - 1) * 9 + col - 2);
                        } else if ((lookAt(row - 1, col - 2) & 8) !== piece_color) {
                            validMove.push(id, (row - 1) * 9 + col - 2);
                        }
                    }
                    if (row < 9) {
                        if (lookAt(row + 1, col - 2) === 0) {
                            validMove.push(id, (row + 1) * 9 + col - 2);
                        } else if ((lookAt(row + 1, col - 2) & 8) !== piece_color) {
                            validMove.push(id, (row+1) * 9 + col -2);
                        }
                    }
                }
                if (col <7 && lookAt(row, col+1) === 0) {//không bị cản phía phải
                    if (row > 0) {
                        if (lookAt(row - 1, col + 2) === 0) {
                            validMove.push(id, (row - 1) * 9 + col + 2);
                        } else if ((lookAt(row - 1, col + 2) & 8) !== piece_color) {
                            validMove.push(id, (row - 1) * 9 + col + 2);
                        }
                    }
                    if (row < 9) {
                        if (lookAt(row + 1, col + 2) === 0) {
                            validMove.push(id, (row + 1) * 9 + col + 2);
                        } else if ((lookAt(row + 1, col + 2) & 8 )!== piece_color) {
                            validMove.push(id, (row+1) * 9 + col + 2);
                        }
                    }
                }
                break;
            case 7://tốt
                if(piece_color !== myColor){//other Player
                    if(row<9){
                        if(lookAt(row+1, col)===0){
                            validMove.push(id, (row+1)*9+col);
                        }else if((lookAt(row+1, col)&8) !== piece_color){
                            validMove.push(id, (row+1)*9+col);
                        }
                    }
                    if(row>4){//đã sang sông
                        if(col<8){
                            if(lookAt(row, col+1)===0){
                                validMove.push(id, row*9+col+1);
                            }else if((lookAt(row, col+1)&8) !== piece_color){
                                validMove.push(id, row*9+col+1);
                            }
                        }
                        if(col>0){
                            if(lookAt(row, col-1)===0){
                                validMove.push(id, row*9+col-1);
                            }else if((lookAt(row, col-1)&8) !== piece_color){
                                validMove.push(id, row*9+col-1);
                            }
                        }
                    }
                }else{//player
                    if(row>0){
                        if(lookAt(row-1, col)===0){
                            validMove.push(id, (row-1)*9+col);
                        }else if((lookAt(row-1, col)&8) !== piece_color){
                            validMove.push(id, (row-1)*9+col);
                        }
                    }
                    if(row<5){//đã sang sông
                        if(col<8){
                            if(lookAt(row, col+1)===0){
                                validMove.push(id, row*9+col+1);
                            }else if((lookAt(row, col+1)&8) !== piece_color){
                                validMove.push(id, row*9+col+1);
                            }
                        }
                        if(col>0){
                            if(lookAt(row, col-1)===0){
                                validMove.push(id, row*9+col-1);
                            }else if((lookAt(row, col-1)&8) !== piece_color){
                                validMove.push(id, row*9+col-1);
                            }
                        }
                    }
                }
                break;
        }
    }
    
    function drawBoard(){
        //vẽ bàn c�? và đánh dấu các nước đi hợp lệ
        var boardCtx = boardCanvas.getContext("2d");
        boardCtx.drawImage(boardImg, 0, 0, boardWidth, boardHeight);
        var i, pieceCtx, piece, piece_type, piece_color;
        for(i=0; i<90; i++){
            piece = board[i];
            pieceCtx = pieceCanvas[i].getContext("2d");
            pieceCtx.clearRect(0, 0, cellSize, cellSize);
            if(piece!==0){
                piece_type = piece&7;
                piece_color = piece>>3;
                pieceCtx.drawImage(pieceImgs[piece_color][piece_type], 0, 0, cellSize, cellSize);
            }
        }
        if(focused!==-1){
            pieceCtx = pieceCanvas[focused].getContext("2d");
            pieceCtx.drawImage(focusImg, -3, -3, cellSize+3, cellSize+3);
            var length = focusedValidMove.length;
            for(i=1; i<length; i+=2){
                pieceCtx = pieceCanvas[focusedValidMove[i]].getContext("2d");
                pieceCtx.drawImage(validMoveImg, 0, 0, cellSize, cellSize);
            }
        }
    }
    function hideCheckWarning(){
        //ẩn thông báo chiếu tướng trên bàn c�? 
        infoCanvas.style.display = "none";
    }
    function showCheckWarning(){
        //hiện thông báo chiếu tướng trên bàn c�?
        var infoCtx, img;
        img = checkImg;
        
        infoCtx = infoCanvas.getContext("2d");
        infoCtx.clearRect(0,0,infoCanvas.width,infoCanvas.height);
        var height = img.height, width = img.width;
        var heightRatio = height / infoCanvas.height;
        var widthRatio = width / infoCanvas.width;
        var maxRatio = max(heightRatio, widthRatio);
        if(maxRatio > 1){
            height = height / maxRatio;
            width = width / maxRatio;
        }
        infoCtx.drawImage(img, infoCanvas.width/2 - (width/2), infoCanvas.height/2 - height/2, width, height);
        infoCanvas.style.display = "inline";
        setTimeout(hideCheckWarning, 700);
    }

    function imageLoaded(){
        imageCount++;
        if(imageCount>=21){
            drawBoard();
        }
    }
    
    function reset(){
            board = [
            4, 6, 3, 2, 1, 2, 3, 6, 4,
            0, 0, 0, 0, 0, 0, 0, 0, 0,
            0, 5, 0, 0, 0, 0, 0, 5, 0,
            7, 0, 7, 0, 7, 0, 7, 0, 7,
            0, 0, 0, 0, 0, 0, 0, 0, 0,
            0, 0, 0, 0, 0, 0, 0, 0, 0,
           15, 0,15, 0, 15, 0,15, 0,15,
            0,13, 0, 0, 0, 0, 0,13, 0,
            0, 0, 0, 0, 0, 0, 0, 0, 0,
           12,14,11,10, 9,10,11,14,12 
            ];
            //gameOver = true;
            //isCheck = false;
            controlDiv.innerHTML = '';
            controlDiv.appendChild(leaveRoomButton);
            controlDiv.appendChild(readyButton);
            gameStart = false;
            focusedValidMove=[];
            focused = -1;
            infoCanvas.style.display = "none";
            drawBoard();
    }
    
    function moveAnimatedly(id1, id2){
        //tạo chuyển động cho quân c�?, cập nhật bàn c�?, turn
        var r1, r2, c1, c2, x1, x2, y1, y2, piece, ctx, img, x, y, dx, dy, i, timer, intervals = 20;
        function exec(){
            i++;
            if(i>=intervals){
                board[id2] = piece;
                animateCanvas.style.display = "none";
                drawBoard();
                return;
            }
            ctx.clearRect(x-1, y-1, cellSize+2, cellSize+2);
            x += dx; y += dy;
            ctx.drawImage(img, x, y, cellSize, cellSize);
            timer = setTimeout(exec, 10);
        }
        
        focusedValidMove = [];
        focused = -1;
        turn = turn^8;
        
        c1 = id1 % 9;
        r1 = (id1-c1) / 9;
        c2 = id2 % 9;
        r2 = (id2-c2) / 9;
        x1 = c1 * cellSize;
        y1 = r1 * cellSize;
        x2 = c2 * cellSize;
        y2 = r2 * cellSize;
        piece = board[id1];
        img = pieceImgs[piece>>3][piece&7];
        x = x1; y = y1;
        dx = (x2 - x1)/intervals;
        dy = (y2 - y1)/intervals;
        board[id1] = 0;
        drawBoard();
        animateCanvas.style.display = "inline";
        ctx = animateCanvas.getContext("2d");
        ctx.clearRect(0, 0, animateCanvas.width, animateCanvas.height);
        i = 0;
        exec();
    }
    
    function showMessage(s){
        $("#messageDialog").html(s);
        $("#messageDialog").dialog('open');
    }
    function closeRoom(){
        haveRoom = false;
        document.location.hash = "#listRoomDiv";
    }
//==========Các hàm được g�?i khi server phát event tương ứng==============
    //các sự kiện khi chơi game 
    function onBoardInfo(data){
        console.log("onBoardInfo");
        var ob = data;
        if(gameStart === false){
            if(ob.turn === username){
                myColor = 8;//đ�?, đi trước
            }else{
                myColor = 0;
            }
            turn = 8;
            gameStart = true;
            controlDiv.innerHTML='';
            controlDiv.appendChild(leaveRoomButton);
            controlDiv.appendChild(giveUpButton);
        }
        for(var i = 0; i< 90; i++){
            board[i] = 0;
        }
        for( var i in ob.board){
            if(myColor===0){//quân đen, phải xoay ngược bàn
                board[90-i.cid] = i.pid;
            }else{//quân đ�?, không cần xoay bàn
                board[i.cid] = i.pid;
            }
        }
        drawBoard();
    }
    function onOpMove(data){
        console.log("onOpMove");
        var move = data;
        if(myColor===0){
            moveAnimatedly(90-move.id1, 90-move.id2);
            console.log("onOpMove: "+(89-move.id1)+":"+(89-move.id2));
        }else{
            moveAnimatedly(move.id1, move.id2);
            console.log("onOpMove: "+move.id1+":"+move.id2);
        }
    }
    function onCheck(){
        showCheckWarning();
    }
    function onLose(){
        console.log("onLose");
        gameStart = false;
        showMessage("Bạn đã thua ván này!");
        controlDiv.innerHTML='';
        controlDiv.appendChild(leaveRoomButton);
        controlDiv.appendChild(nextButton);
    }
    function onWin(){
        console.log("onWin");
        gameStart = false;
        showMessage("Chúc mừng! Bạn đã thua ván này.");
        controlDiv.innerHTML='';
        controlDiv.appendChild(leaveRoomButton);
        controlDiv.appendChild(nextButton);
    }
    function onLoseRoom(){
        console.log("onLoseRoom");
        gameStart = false;
        showMessage("Bạn đã thua. Cơ hội cho bạn đã hết!");
        controlDiv.innerHTML='';
        controlDiv.appendChild(closeRoomButton);
    }
    function onWinRoom(){
        console.log("onWinRoom");
        gameStart = false;
        showMessage("Chúc mừng! Bạn là ngư�?i chiến thắng trong phòng chơi này");
        controlDiv.innerHTML='';
        controlDiv.appendChild(closeRoomButton);
    }
    function onInvalidMove(){
        console.log("onInvalidMove");
        showMessage("Nước đi của bạn không hợp lệ");
    }
    function onLoseGU(){
        console.log("onLoseGU");
        gameStart = false;
        showMessage("Rất tiếc khi bạn đã từ b�? ván chơi này");
        controlDiv.innerHTML='';
        controlDiv.appendChild(leaveRoomButton);
        controlDiv.appendChild(nextButton);
    }
    function onWinGU(){
        console.log("onWinGU");
        gameStart = false;
        showMessage("�?ối thủ đã b�? cuộc. Bạn là ngư�?i chiến thắng trong ván này!");
        controlDiv.innerHTML='';
        controlDiv.appendChild(leaveRoomButton);
        controlDiv.appendChild(nextButton);
    }
    function onLoseRoomGU(){
        console.log("onLoseRoomGU");
        gameStart = false;
        showMessage("Rất tiếc khi bạn đã b�? cuộc và nhận thua trong phòng chơi này");
        haveRoom = false;
        document.location.hash = "#listRoomDiv";
    }
    function onWinRoomGU(){
        console.log("onWinRoomGU");
        gameStart = false;
        showMessage("�?ối thủ đã b�? cuộc. Bạn là ngư�?i chiến thắng trong phòng này");
        controlDiv.innerHTML='';
        controlDiv.appendChild(closeRoomButton);
    }
    //các sự kiện khác
    function onRoomList(data){
        console.log("onRoomList");
        roomList = data;
        updateRoomList(roomList);
    }
    function updateRoomList(list){//không tương ứng với event
        if(list.length === 0){
            $("#roomTableDiv").html("Không có dữ liệu");
        }else{
            var table = $("#roomTable");
            table.html("<tr> <th>ID</th> <th>Tên phòng</th> <th>Số ngư�?i chơi</th> <th>Số ván</th><th>Chủ phòng</th> <th>Xu</th> <th>Lock</th> <th></th> </tr>");
            for(var room in list){
			var row = "<tr>" + "<td>"+list[room].ID+"</td>"+
                "<td>"+list[room].name+"</td>"+
                "<td>"+list[room].countPlaying+"</td>"+
                "<td>"+list[room].matchLimit+"</td>"+
                "<td>"+list[room].boss+"</td>"+				
                "<td>"+list[room].coin+"</td>";
				if(list[room].password !== "") row = row+ "<td>LOCK</td>"+"<td><button class='button' onclick='joinRoom("+list[room].ID+","+list[room].password+");' >Tham gia</button></td>" +"</tr>";
				else row = row + "<td>NO</td>"+
				"<td><button class='button' onclick='joinRoom("+list[room].ID+","+"false);' >Tham gia</button></td>" +
				 "</tr>";
                table.append(row);
            }
        }
    }
    function onErr(id){
        switch(id){
            case "1" : showMessage("Không định danh được ngư�?i dùng. Hãy chắc chắn bạn đã đăng nhập"); break;
            case "2" : showMessage("Phòng chơi không hợp lệ"); break;
            case "3" : showMessage("Bạn đã nhập sai password cho phòng chơi"); break;
            case "4" : showMessage("Nước bạn vừa đi không hợp lệ"); break;
            case "5" : showMessage("�?ã xảy ra lỗi hệ thống"); break;
            case "6" : showMessage("Lỗi không xác định"); break;
			case "7" : showMessage("Tài khoản đang được sử dụng"); break;
            default : showMessage("Mã lỗi không đúng. "); break;
        }
    }
    function onRoomInfo(data){
        console.log("onRoomInfo");
        roomInfo = data;
        console.log("onRoomInfo: "+roomInfo.ID);
        var html = "<b>Mã phòng chơi</b>"+roomInfo.ID+
                "<br/><b>Tên phòng chơi</b>"+roomInfo.name+
                "<br/><b>Số trận</b>"+roomInfo.match+
                "<br/><b>Số ti�?n cược</b>"+roomInfo.coin;
        $("#roomInfoDiv").html(html);
    }
    function onLogging(){
        
    }
    function onAdded(){
        console.log("onAdded");
        haveRoom = true;
        ownRoom = true;
        reset();
        document.location.hash="#roomDiv";
    }
    function onJoined(){
        console.log("onJoined");
        haveRoom = true;
        ownRoom = false;
        reset();
        document.location.hash="#roomDiv";
    }
    function onRoomFull(){
        showMessage("Phòng chơi đã đủ ngư�?i, nhấn 'Bắt đầu' để chơi");
    }
    //chat
    function onChatMessage(){
        console.log("onChatMessage");
    }
    function onChatRoomMessage(s){
        var m = s;
        console.log("onChatRoomMessage: "+m.username+" "+m.message);
        $("#messagesDiv").append("<b>"+m.username+":</b> "+m.message+"<br/>");
    }
//==========END - Các hàm được g�?i khi server phát event tương ứng==============

//===========Các hàm phát sự kiện lên server======================
    function connectToServer(){
        console.log("connectToServer");
        var ob={};
        //ob.token = "xax";
        ob.token = "kaka";
        ob.username = "hp";
        socket.emit('connectToServer', {token : "xax", username : "hp"});
    }
    function move(id1, id2) {
        var ob={};
        moveAnimatedly(id1, id2);
        if(myColor===0){
            id1 = 90 - id1;
            id2 = 90 - id2;
        }
        ob.id1 = id1;
        ob.id2 = id2;
        console.log("move: "+ob.id1+" "+ob.id2);
        socket.emit('move', ob);
    }
//===========END - Các hàm phát sự kiện lên server======================
    function resize() {
        cellSize = min((window.innerHeight * 0.8) / 10, (window.innerWidth * 0.8) / 9);
        boardHeight = cellSize * 10;
        boardWidth = cellSize * 9;
        mainDiv.style.width = boardWidth + 10 + "px";
        gameDiv.style.height = boardHeight + "px";
        gameDiv.style.width = boardWidth + "px";
        infoCanvas.width = boardWidth;
        infoCanvas.height = (boardHeight * 0.3);
        infoCanvas.style.top = (boardHeight * 0.3) + "px";
        boardCanvas.height = boardHeight;
        boardCanvas.width = boardWidth;
        animateCanvas.width = boardWidth;
        animateCanvas.height = boardHeight;
        for (var i = 0; i < 90; i++) {
            pieceCanvas[i].height = cellSize;
            pieceCanvas[i].width = cellSize;
        }
        drawBoard();
    }
    //PUBLIC API
    return {
        onHashChange: function () {
            console.log("onHashChange");
//            if (document.location.hash === "#roomDiv") {
//                document.getElementById("listRoomDiv").style.display = "none";
//                document.getElementById("roomDiv").style.display = "block";
//                reset();
//            } else {
//                document.getElementById("listRoomDiv").style.display = "block";
//                document.getElementById("roomDiv").style.display = "none";  
//            }
              if(haveRoom === true){
                  document.location.hash = "#roomDiv";
                  document.getElementById("listRoomDiv").style.display = "none";
                  document.getElementById("roomDiv").style.display = "block";
              }else{
                  document.location.hash = "#listRoomDiv";
                  document.getElementById("listRoomDiv").style.display = "block";
                  document.getElementById("roomDiv").style.display = "none";
              }
        },
        boardClicked: function(id){
            if(turn===myColor && gameStart){
                var piece = board[id];
                if(focused!==-1){
                    var i, length = focusedValidMove.length;
                    for(i=1; i<length; i+=2){
                        if(focusedValidMove[i]===id){
                            break;
                        }
                    }
                    if(i<length){//valid move
                        move(focused, id);                  
                    }else{//not valid move
                        if((piece&8) === myColor){
                            focused = id;
                            focusedValidMove = [];
                            validMoveGen(focused, focusedValidMove);
                            drawBoard();
                       }else{
                            focused = -1;
                            focusedValidMove = [];
                            drawBoard();
                      }
                    }
                }else{//focused == -1
                    if((piece&8) === myColor){
                        focused = id;
                        focusedValidMove = [];
                        validMoveGen(focused, focusedValidMove);
                        drawBoard();
                    }
                }
            }          
        },
        place: function(id){
            var i, j;
            for(i=0; i<=1; i++){
                for(j=1;j<=7; j++){
                    pieceImgs[i][j] = new Image();
                    pieceImgs[i][j].src = "imgs/"+i+j+".png";
                    pieceImgs[i][j].onload = imageLoaded;
                }
            }
            boardImg = new Image();
            boardImg.src = "imgs/board.png";
            boardImg.onload = imageLoaded;
            
            focusImg = new Image();
            focusImg.src = "imgs/select.png";
            focusImg.onload = imageLoaded;
            
            validMoveImg = new Image();
            validMoveImg.src = "imgs/valid.png";
            validMoveImg.onload = imageLoaded;
            
            winImg = new Image();
            winImg.onload = imageLoaded;
            winImg.src = "imgs/win.png";
            
            loseImg = new Image();
            loseImg.onload = imageLoaded;
            loseImg.src = "imgs/lose.png";
            
            checkImg = new Image();
            checkImg.onload = imageLoaded;
            checkImg.src = "imgs/check.png";
            
            cellSize = min((window.innerHeight*0.8)/10, (window.innerWidth*0.8)/9);
            boardHeight = cellSize*10;
            boardWidth = cellSize*9;
            mainDiv = document.getElementById(id);
            mainDiv.style.width = boardWidth+10+"px";
            controlDiv = document.createElement("div");
            controlDiv.id = "controlDiv";
            
            
            gameDiv = document.createElement("div");
            gameDiv.id = "gameDiv";
            gameDiv.style.height = boardHeight+"px";
            gameDiv.style.width = boardWidth+"px";
            
            infoCanvas = document.createElement("canvas");
            infoCanvas.id = "infoCanvas";
            infoCanvas.width = boardWidth;
            infoCanvas.height = (boardHeight*0.3);
            infoCanvas.style.top = (boardHeight*0.3)+"px";
            //infoCanvas.onclick = hideInfo;
            
            animateCanvas = document.createElement("canvas");
            animateCanvas.id = "animateCanvas";
            animateCanvas.width = boardWidth;
            animateCanvas.height = boardHeight;
            
            giveUpButton = document.createElement("button");
            giveUpButton.innerHTML = "Chịu thua";
            giveUpButton.onclick = this.giveup;
            giveUpButton.className = "buttonRed";
            
            leaveRoomButton = document.createElement("button");
            leaveRoomButton.innerHTML = "Hủy phòng";
            leaveRoomButton.onclick = this.leaveRoom;
            leaveRoomButton.className = "buttonRed";
            
            nextButton = document.createElement("button");
            nextButton.innerHTML = "Ván mới";
            nextButton.onclick = reset;
            nextButton.className = "buttonRed";
            
            readyButton = document.createElement("button");
            readyButton.innerHTML = "Sẵn sàng";
            readyButton.onclick = this.readyToPlay;
            readyButton.className = "buttonRed";
            
            closeRoomButton = document.createElement("button");
            closeRoomButton.innerHTML = "�?óng phòng chơi";
            closeRoomButton.onclick = closeRoom;
            closeRoomButton.className = "buttonRed";
                    
            boardCanvas = document.createElement("canvas");
            boardCanvas.height = boardHeight;
            boardCanvas.width = boardWidth;
            boardCanvas.id = "boardCanvas";
            
            gameDiv.appendChild(boardCanvas);
            for(i=0; i<90; i++){
                pieceCanvas[i] = document.createElement("canvas");
                pieceCanvas[i].height = cellSize;
                pieceCanvas[i].width = cellSize;
                pieceCanvas[i].className="pieceCanvas";
                pieceCanvas[i].setAttribute("onclick", "controller.boardClicked("+i+")");
                gameDiv.appendChild(pieceCanvas[i]);
            }
            gameDiv.appendChild(animateCanvas);
            gameDiv.appendChild(infoCanvas);
            
            controlDiv.appendChild(leaveRoomButton);
            controlDiv.appendChild(readyButton);
            
            mainDiv.appendChild(gameDiv);  
            mainDiv.appendChild(controlDiv);
            window.onresize = resize;
            
            //Tao socket
            socket = io.connect(connectURL);
			socket.on('connectToServer', roomList);
            socket.on('boardInfo', onBoardInfo);
            socket.on('opMove', onOpMove);
            socket.on('check', onCheck);
            socket.on('lose', onLose);
            socket.on('win', onWin);
            socket.on('loseRoom', onLoseRoom);
            socket.on('winRoom', onWinRoom);
            socket.on('invalidMove', onInvalidMove);
            socket.on('loseGU', onLoseGU);
            socket.on('winGU', onWinGU);
            socket.on('loseRoomGU', onLoseRoomGU);
            socket.on('winRoomGU', onWinRoomGU);
            socket.on('logging', onLogging);
            socket.on('roomInfo', onRoomInfo);
            socket.on('err', onErr);
            socket.on('roomList', onRoomList);
            socket.on('chatmessage', onChatMessage);
            socket.on('chatroommessage', onChatRoomMessage);
            socket.on('joined', onJoined);
            socket.on('added', onAdded);
            socket.on('roomFull', onRoomFull);
			socket.on('notGiveUp','');
        },
        initController: function(id){
            this.place(id);
            reset();
            imageLoaded();//đảm bảo tất cả đã sẵn sàng trước khi g�?i hàm drawBoard() lần đầu tiên
            connectToServer();
          //  updateRoomList(roomList);
        },
        joinRoom: function(id, pass){
            var ob={};
            ob.sessionId = token;
            ob.roomID = id;
            ob.pass = pass;
            console.log("joinRoom: "+ob.sessionId+" "+ob.roomID+" "+ob.pass);
            socket.emit('joinRoom', {sessionId : "xax", roomID : id, pass: pass});
        },
        refreshRoom: function(){
            console.log("refreshRoom");
            socket.emit('refreshRoom','');
        },
        addRoom: function(ob){
            console.log("addRoom "+ob.name+" "+ob.coin+" "+ob.pass);
            socket.emit('addRoom', ob);
        },
        readyToPlay: function(){
            console.log("readToPlay");
            controlDiv.innerHTML='';
            controlDiv.appendChild(leaveRoomButton);
            /*controlDiv.appendChild(giveUpButton);*/
            controlDiv.appendChild(document.createTextNode("�?ang đợi ngư�?i chơi còn lại sẵn sàng"));
            socket.emit('readyToPlay');
        },
        giveup: function(){
            console.log("giveup");
            if(confirm("Bạn có chắc chắn sẽ chịu thua ván này?")){
                gameStart = false;
                controlDiv.innerHTML='';
                controlDiv.appendChild(leaveRoomButton);
                controlDiv.appendChild(nextButton);
                socket.emit('giveUp','');
            }
        },
        leaveRoom: function(){
            console.log("leaveRoom");
            if(confirm("Bạn có chắc chắn sẽ chịu thua phòng chơi này?")){
                console.log("leaveRoom confirmed");
                gameStart = false;
                socket.emit('leaveRoom','');
                haveRoom = false;
                document.location.hash = "#listRoomDiv";
            }
        },
        leavePage: function(){
            gameStart = false;
            socket.emit('leaveRoom','');
        },
        chatInRoom: function(){
            var s = $("#messageInput").val();
            console.log("chatInRoom: "+s);
            socket.emit('chatInRoom', s);
            $("#messageInput").val("");
            event.preventDefault();
        },
        chatFriend: function(){
        
        },
        searchRoom: function(s){
            console.log("SearchRoom "+s);
        }
    };
}());
