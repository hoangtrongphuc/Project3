/* 
 * Copyright (c) 10-2014 Nguyen Tat Nguyen
 */

var chess = (function () {
    var valueByPlace=[
            [],//ignore index 0
            [//index 1 - Tướng
                0,0,0,0,0,0,0,0,0,
                0,0,0,0,0,0,0,0,0,
                0,0,0,0,0,0,0,0,0,
                0,0,0,0,0,0,0,0,0,
                0,0,0,0,0,0,0,0,0,//sông
                0,0,0,0,0,0,0,0,0,//sông
                0,0,0,0,0,0,0,0,0,
                0,0,0,1,1,1,0,0,0,
                0,0,0,2,2,2,0,0,0,
                0,0,0,11,15,11,0,0,0
            ],
            [//index 2 - sĩ
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0,  0,  0,  0,  0,  0,  0,  0,//sông
                  0,  0,  0,  0,  0,  0,  0,  0,  0,//sông
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0,  0, 20,  0, 20,  0,  0,  0,
                  0,  0,  0,  0, 23,  0,  0,  0,  0,
                  0,  0,  0, 20,  0, 20,  0,  0,  0
            ],
            [//index 3 - tượng
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0,  0,  0,  0,  0,  0,  0,  0,//sông
                  0,  0, 20,  0,  0,  0, 20,  0,  0,//sông
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                 18,  0,  0,  0, 23,  0,  0,  0, 18,
                  0,  0,  0,  0,  0,  0,  0,  0,  0,
                  0,  0, 20,  0,  0,  0, 20,  0,  0
            ],
            [//index 4 - xe
                206,208,207,213,214,213,207,208,206,
                206,212,209,216,233,216,209,212,206,
                206,208,207,214,216,214,207,208,206,
                206,213,213,216,216,216,213,213,206,
                208,211,211,214,215,214,211,211,208,//
                208,212,212,214,215,214,212,212,208,//
                204,209,204,212,214,212,204,209,204,
                198,208,204,212,212,212,204,208,198,
                200,208,206,212,200,212,206,208,200,
                194,206,204,212,200,212,204,206,194
            ],
            [//index 5 - pháo
                100,100, 96, 91, 90, 91, 96,100,100,
                98, 98, 96, 92, 89, 92, 96, 98, 98,
                97, 97, 96, 91, 92, 91, 96, 97, 97,
                96, 99, 99, 98,100, 98, 99, 99, 96,
                96, 96, 96, 96,100, 96, 96, 96, 96,//
                95, 96, 99, 96,100, 96, 99, 96, 95,//
                96, 96, 96, 96, 96, 96, 96, 96, 96,
                97, 96,100, 99,101, 99,100, 96, 97,
                96, 97, 98, 98, 98, 98, 98, 97, 96,
                96, 96, 97, 99, 99, 99, 97, 96, 96
            ],
            [//index 6 - mã
                90, 90, 90, 96, 90, 96, 90, 90, 90,
                90, 96,103, 97, 94, 97,103, 96, 90, 
                92, 98, 99,103, 99,103, 99, 98, 92, 
                93,108,100,107,100,107,100,108, 93,  
                90,100, 99,103,104,103, 99,100, 90,//
                90, 98,101,102,103,102,101, 98, 90,//
                92, 94, 98, 95, 98, 95, 98, 94, 92,  
                93, 92, 94, 95, 92, 95, 94, 92, 93, 
                85, 90, 92, 93, 78, 93, 92, 90, 85,  
                88, 85, 90, 88, 90, 88, 90, 85, 88
            ],
            [//index 7 - tốt
                9,  9,  9, 11, 13, 11,  9,  9,  9,
               19, 24, 34, 42, 44, 42, 34, 24, 19,
               19, 24, 32, 37, 37, 37, 32, 24, 19,
               19, 23, 27, 29, 30, 29, 27, 23, 19,
               14, 18, 20, 27, 29, 27, 20, 18, 14,//
                7,  0, 13,  0, 16,  0, 13,  0,  7,//
                7,  0,  7,  0, 15,  0,  7,  0,  7,  
                0,  0,  0,  0,  0,  0,  0,  0,  0,  
                0,  0,  0,  0,  0,  0,  0,  0,  0,  
                0,  0,  0,  0,  0,  0,  0,  0,  0
            ]
        ], 
        board=[],
        depth = 3,
        turn,
        gameOver,
        isCheck,
        focusedValidMove=[],
        focused,
        bestMove=[],
        mainDiv,
        controlDiv,
        gameDiv,
        infoCanvas,
        newGameButton,
        depthCombobox,
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
    function lookAt(r, c) {
        return board[r * 9 + c];
    }
    function validMoveGen(id, _captureMove, _otherMove, _pieceCount, _otherScore){
        var piece = board[id];
        if(piece===0) return;//can be delete
        var col = id % 9;
        var row = (id-col) / 9;
        var piece_type = piece&7;
        var piece_color = piece&8;
        switch(piece_type){
            case 1://tướng
                _pieceCount[1]++;
                if(piece_color === 0){//engine
                    if(row>0){
                        if(lookAt(row-1,col)===0){
                            _otherMove.push(id, (row-1)*9+col);
                        }else if((lookAt(row-1,col)&8)!==piece_color){
                            _captureMove.push(id, (row-1)*9+col);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<2){
                        if(lookAt(row+1,col)===0){
                            _otherMove.push(id, (row+1)*9+col);
                        }else if((lookAt(row+1,col)&8)!==piece_color){
                            _captureMove.push(id, (row+1)*9+col);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(col>3){
                        if(lookAt(row,col-1)===0){
                            _otherMove.push(id, row*9+col-1);
                        }else if((lookAt(row,col-1)&8)!==piece_color){
                            _captureMove.push(id, row*9+col-1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(col<5){
                        if(lookAt(row,col+1)===0){
                            _otherMove.push(id, row*9+col+1);
                        }else if((lookAt(row,col+1)&8)!==piece_color){
                            _captureMove.push(id, row*9+col+1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    //hở mặt tướng
                    for(var i = row+1; i<10; i++){
                        if(lookAt(i,col)!==0){
                            if(lookAt(i,col)===9){
                                _captureMove.push(id, i*9+col);
                            }
                            break;
                        }
                    }
                }else{//player
                    if(row>7){
                        if(lookAt(row-1,col)===0){
                            _otherMove.push(id, (row-1)*9+col);
                        }else if((lookAt(row-1,col)&8)!==piece_color){
                            _captureMove.push(id, (row-1)*9+col);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<9){
                        if(lookAt(row+1,col)===0){
                            _otherMove.push(id, (row+1)*9+col);
                        }else if((lookAt(row+1,col)&8)!==piece_color){
                            _captureMove.push(id, (row+1)*9+col);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(col>3){
                        if(lookAt(row,col-1)===0){
                            _otherMove.push(id, row*9+col-1);
                        }else if((lookAt(row,col-1)&8)!==piece_color){
                            _captureMove.push(id, row*9+col-1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(col<5){
                        if(lookAt(row,col+1)===0){
                            _otherMove.push(id, row*9+col+1);
                        }else if((lookAt(row,col+1)&8)!==piece_color){
                            _captureMove.push(id, row*9+col+1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    //hở mặt tướng
                    for(var i = row-1; i>=0; i--){
                        if(lookAt(i,col)!==0){
                            if(lookAt(i,col)===1){
                                _captureMove.push(id, i*9+col);
                            }
                            break;
                        }
                    }
                }
                break;
            case 2://sĩ
                _pieceCount[2]++;
                if(piece_color===0){//engine
                    if(row>0 && col>3){
                        if(lookAt(row-1, col-1)===0){
                            _otherMove.push(id, (row-1)*9+col-1);
                        }else if((lookAt(row-1, col-1)&8) !== piece_color){
                            _captureMove.push(id, (row-1)*9+col-1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<2 && col<5){
                        if(lookAt(row+1, col+1)===0){
                            _otherMove.push(id, (row+1)*9+col+1);
                        }else if((lookAt(row+1, col+1)&8) !== piece_color){
                            _captureMove.push(id, (row+1)*9+col+1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row>0 && col<5){
                        if(lookAt(row-1, col+1)===0){
                            _otherMove.push(id, (row-1)*9+col+1);
                        }else if((lookAt(row-1, col+1)&8) !== piece_color){
                            _captureMove.push(id, (row-1)*9+col+1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<2 && col>3){
                        if(lookAt(row+1, col-1)===0){
                            _otherMove.push(id, (row+1)*9+col-1);
                        }else if((lookAt(row+1, col-1)&8) !== piece_color){
                            _captureMove.push(id, (row+1)*9+col-1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                }else{//player
                    if(row>7 && col>3){
                        if(lookAt(row-1, col-1)===0){
                            _otherMove.push(id, (row-1)*9+col-1);
                        }else if((lookAt(row-1, col-1)&8) !== piece_color){
                            _captureMove.push(id, (row-1)*9+col-1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<9 && col<5){
                        if(lookAt(row+1, col+1)===0){
                            _otherMove.push(id, (row+1)*9+col+1);
                        }else if((lookAt(row+1, col+1)&8) !== piece_color){
                            _captureMove.push(id, (row+1)*9+col+1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row>7 && col<5){
                        if(lookAt(row-1, col+1)===0){
                            _otherMove.push(id, (row-1)*9+col+1);
                        }else if((lookAt(row-1, col+1)&8) !== piece_color){
                            _captureMove.push(id, (row-1)*9+col+1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<9 && col>3){
                        if(lookAt(row+1, col-1)===0){
                            _otherMove.push(id, (row+1)*9+col-1);
                        }else if((lookAt(row+1, col-1)&8) !== piece_color){
                            _captureMove.push(id, (row+1)*9+col-1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                }
                break;
            case 3://tượng
                _pieceCount[3]++;
                if(piece_color === 0 ){//engine
                    if(row>0 && col>0 && (lookAt(row-1,col-1)===0)){
                        if(lookAt(row-2, col-2)===0){
                            _otherMove.push(id, (row-2)*9+col-2);
                        }else if((lookAt(row-2, col-2)&8) !== piece_color){
                            _captureMove.push(id, (row-2)*9+col-2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<4 && col<8 && (lookAt(row+1,col+1)===0)){
                        if(lookAt(row+2, col+2)===0){
                            _otherMove.push(id, (row+2)*9+col+2);
                        }else if((lookAt(row+2, col+2)&8) !== piece_color){
                            _captureMove.push(id, (row+2)*9+col+2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row>0 && col<8 && (lookAt(row-1,col+1)===0)){
                        if(lookAt(row-2, col+2)===0){
                            _otherMove.push(id, (row-2)*9+col+2);
                        }else if((lookAt(row-2, col+2)&8) !== piece_color){
                            _captureMove.push(id, (row-2)*9+col+2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<4&& col>0 && (lookAt(row+1,col-1)===0)){
                        if(lookAt(row+2, col-2)===0){
                            _otherMove.push(id, (row+2)*9+col-2);
                        }else if((lookAt(row+2, col-2)&8) !== piece_color){
                            _captureMove.push(id, (row+2)*9+col-2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                }else{//player
                    if(row>5 && col>0 && (lookAt(row-1,col-1)===0)){
                        if(lookAt(row-2, col-2)===0){
                            _otherMove.push(id, (row-2)*9+col-2);
                        }else if((lookAt(row-2, col-2)&8) !== piece_color){
                            _captureMove.push(id, (row-2)*9+col-2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<9 && col<8 && (lookAt(row+1,col+1)===0)){
                        if(lookAt(row+2, col+2)===0){
                            _otherMove.push(id, (row+2)*9+col+2);
                        }else if((lookAt(row+2, col+2)&8) !== piece_color){
                            _captureMove.push(id, (row+2)*9+col+2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row>5 && col<8 && (lookAt(row-1,col+1)===0)){
                        if(lookAt(row-2, col+2)===0){
                            _otherMove.push(id, (row-2)*9+col+2);
                        }else if((lookAt(row-2, col+2)&8) !== piece_color){
                            _captureMove.push(id, (row-2)*9+col+2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<9&& col>0 && (lookAt(row+1,col-1)===0)){
                        if(lookAt(row+2, col-2)===0){
                            _otherMove.push(id, (row+2)*9+col-2);
                        }else if((lookAt(row+2, col-2)&8) !== piece_color){
                            _captureMove.push(id, (row+2)*9+col-2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                }
                break;
            case 4://xe
                _pieceCount[4]++;
                for(var i = col+1; i<9; i++){
                    if(lookAt(row,i)===0){
                        _otherMove.push(id, row*9+i);
                    }else{ 
                        if((lookAt(row,i)&8) !== piece_color){
                            _captureMove.push(id, row*9+i);
                        }else{
                            _otherScore[0]++;
                        }
                        break;
                    }
                }
                for(var i = col-1; i>=0; i--){
                    if(lookAt(row,i)===0){
                        _otherMove.push(id, row*9+i);
                    }else{ 
                        if((lookAt(row,i)&8) !== piece_color){
                            _captureMove.push(id, row*9+i);
                        }else{
                            _otherScore[0]++;
                        }
                        break;
                    }
                }
                for(var i = row+1; i<10; i++){
                    if(lookAt(i,col)===0){
                        _otherMove.push(id, i*9+col);
                    }else{ 
                        if((lookAt(i,col)&8) !== piece_color){
                            _captureMove.push(id, i*9+col);
                        }else{
                            _otherScore[0]++;
                        }
                        break;
                    }
                }
                for(var i = row-1; i>=0; i--){
                    if(lookAt(i,col)===0){
                        _otherMove.push(id, i*9+col);
                    }else{ 
                        if((lookAt(i,col)&8) !== piece_color){
                            _captureMove.push(id, i*9+col);
                        }else{
                            _otherScore[0]++;
                        }
                        break;
                    }
                }
                break;
            case 5://pháo
                _pieceCount[5]++;
                for(var i = col+1; i<9; i++){
                    if(lookAt(row,i)===0){
                        _otherMove.push(id, row*9+i);
                    }else{
                        for(var j = i+1; j<9; j++){
                            if(lookAt(row,j)!==0){
                                if((lookAt(row,j)&8) !== piece_color){
                                    _captureMove.push(id, row*9+j);
                                }else{
                                    _otherScore[0]++;
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
                for(var i = col-1; i>=0; i--){
                    if(lookAt(row,i)===0){
                        _otherMove.push(id, row*9+i);
                    }else{
                        for(var j = i-1; j>=0; j--){
                            if(lookAt(row,j)!==0){
                                if((lookAt(row,j)&8) !== piece_color){
                                    _captureMove.push(id, row*9+j);
                                }else{
                                    _otherScore[0]++;
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
                for(var i = row+1; i<10; i++){
                    if(lookAt(i,col)===0){
                        _otherMove.push(id, i*9+col);
                    }else{
                        for(var j = i+1; j<10; j++){
                            if(lookAt(j,col)!==0){
                                if((lookAt(j,col)&8) !== piece_color){
                                    _captureMove.push(id, j*9+col);
                                }else{
                                    _otherScore[0]++;
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
                for(var i = row-1; i>=0; i--){
                    if(lookAt(i,col)===0){
                        _otherMove.push(id, i*9+col);
                    }else{
                        for(var j = i-1; j>=0; j--){
                            if(lookAt(j,col)!==0){
                                if((lookAt(j,col)&8) !== piece_color){
                                    _captureMove.push(id, j*9+col);
                                }else{
                                    _otherScore[0]++;
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
                break;
            case 6://mã
                _pieceCount[6]++;
                if (row > 1 && lookAt(row - 1, col) === 0) {//không bị cản phía trên
                    if (col > 0) {
                        if (lookAt(row - 2, col - 1) === 0) {
                            _otherMove.push(id, (row - 2) * 9 + col - 1);
                        } else if ((lookAt(row - 2, col - 1) & 8) !== piece_color) {
                            _captureMove.push(id, (row - 2) * 9 + col - 1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if (col < 8) {
                        if (lookAt(row - 2, col + 1) === 0) {
                            _otherMove.push(id, (row - 2) * 9 + col + 1);
                        } else if ((lookAt(row - 2, col + 1) & 8) !== piece_color) {
                            _captureMove.push(id, (row - 2) * 9 + col + 1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                }
                if (row < 8 && lookAt(row + 1, col) === 0) {//không bị cản phía dưới
                    if (col > 0) {
                        if (lookAt(row + 2, col - 1) === 0) {
                            _otherMove.push(id, (row + 2) * 9 + col - 1);
                        } else if ((lookAt(row + 2, col - 1) & 8) !== piece_color) {
                            _captureMove.push(id, (row + 2) * 9 + col - 1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if (col < 8) {
                        if (lookAt(row + 2, col + 1) === 0) {
                            _otherMove.push(id, (row + 2) * 9 + col + 1);
                        } else if ((lookAt(row + 2, col + 1) & 8) !== piece_color) {
                            _captureMove.push(id, (row + 2) * 9 + col + 1);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                }
                if (col > 1 && lookAt(row, col-1) === 0) {//không bị cản phía trái
                    if (row > 0) {
                        if (lookAt(row - 1, col - 2) === 0) {
                            _otherMove.push(id, (row - 1) * 9 + col - 2);
                        } else if ((lookAt(row - 1, col - 2) & 8) !== piece_color) {
                            _captureMove.push(id, (row - 1) * 9 + col - 2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if (row < 9) {
                        if (lookAt(row + 1, col - 2) === 0) {
                            _otherMove.push(id, (row + 1) * 9 + col - 2);
                        } else if ((lookAt(row + 1, col - 2) & 8) !== piece_color) {
                            _captureMove.push(id, (row+1) * 9 + col -2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                }
                if (col <7 && lookAt(row, col+1) === 0) {//không bị cản phía phải
                    if (row > 0) {
                        if (lookAt(row - 1, col + 2) === 0) {
                            _otherMove.push(id, (row - 1) * 9 + col + 2);
                        } else if ((lookAt(row - 1, col + 2) & 8) !== piece_color) {
                            _captureMove.push(id, (row - 1) * 9 + col + 2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if (row < 9) {
                        if (lookAt(row + 1, col + 2) === 0) {
                            _otherMove.push(id, (row + 1) * 9 + col + 2);
                        } else if ((lookAt(row + 1, col + 2) & 8 )!== piece_color) {
                            _captureMove.push(id, (row+1) * 9 + col + 2);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                }
                break;
            case 7://tốt
                _pieceCount[7]++;
                if(piece_color === 0){//engine
                    if(row<9){
                        if(lookAt(row+1, col)===0){
                            _otherMove.push(id, (row+1)*9+col);
                        }else if((lookAt(row+1, col)&8) !== piece_color){
                            _captureMove.push(id, (row+1)*9+col);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row>4){//đã sang sông
                        if(col<8){
                            if(lookAt(row, col+1)===0){
                                _otherMove.push(id, row*9+col+1);
                            }else if((lookAt(row, col+1)&8) !== piece_color){
                                _captureMove.push(id, row*9+col+1);
                            }else{
                                _otherScore[0]++;
                            }
                        }
                        if(col>0){
                            if(lookAt(row, col-1)===0){
                                _otherMove.push(id, row*9+col-1);
                            }else if((lookAt(row, col-1)&8) !== piece_color){
                                _captureMove.push(id, row*9+col-1);
                            }else{
                                _otherScore[0]++;
                            }
                        }
                    }
                }else{//player
                    if(row>0){
                        if(lookAt(row-1, col)===0){
                            _otherMove.push(id, (row-1)*9+col);
                        }else if((lookAt(row-1, col)&8) !== piece_color){
                            _captureMove.push(id, (row-1)*9+col);
                        }else{
                            _otherScore[0]++;
                        }
                    }
                    if(row<5){//đã sang sông
                        if(col<8){
                            if(lookAt(row, col+1)===0){
                                _otherMove.push(id, row*9+col+1);
                            }else if((lookAt(row, col+1)&8) !== piece_color){
                                _captureMove.push(id, row*9+col+1);
                            }else{
                                _otherScore[0]++;
                            }
                        }
                        if(col>0){
                            if(lookAt(row, col-1)===0){
                                _otherMove.push(id, row*9+col-1);
                            }else if((lookAt(row, col-1)&8) !== piece_color){
                                _captureMove.push(id, row*9+col-1);
                            }else{
                                _otherScore[0]++;
                            }
                        }
                    }
                }
                break;
        }
    }
    function evaluate(captureMove, otherMove, pieceCount, otherScore,//engine
                      opCaptureMove, opOtherMove, opPieceCount, opOtherScore){//player
        var val = 0;
        var piece, piece_type, piece_color;
        for(var i =0; i<90; i++){
            piece = board[i];
            if(piece===0) continue;
            piece_type = piece&7;
            piece_color = piece&8;
            val += piece_color!==0 ? -valueByPlace[piece_type][i] : valueByPlace[piece_type][89-i];
        }
        val +=  (captureMove.length - opCaptureMove.length)/4; //each move represented by two number
        //val +=  (otherMove.length -opOtherMove.length)/16; // loại bỏ vì không thấy hiệu quả
        val +=  (otherScore[0] - opOtherScore[0])/6;//protection
        //được thêm 2 điểm nếu còn đủ sĩ, tượng
//        if(pieceCount[2]===2){
//            val += 2;
//        }
//        if(opPieceCount[2]===2){
//            val -= 2;
//        }
//        if(pieceCount[3]===2){
//            val += 2;
//        }
//        if(opPieceCount[3]===2){
//            val -= 2;
//        }
        return val;
    }
   
    function alphaBetaSearch(a, b, dep, isQS, isRoot, isCapture, _turn){
        var captureMove=[],
        otherMove=[],
        pieceCount = [0,0,0,0,0,0,0,0],
        otherScore = [0],//for now, otherScore[0] : protection score
        opCaptureMove = [],
        opOtherMove = [],
        opPieceCount = [0,0,0,0,0,0,0,0],
        opOtherScore = [0],
        prevValue;
        for(var i = 0; i<90; i++){
            if(board[i]!==0){
                if ((board[i]&8)===_turn){
                    validMoveGen(i, captureMove, otherMove, pieceCount, otherScore);
                }else{
                    validMoveGen(i, opCaptureMove, opOtherMove, opPieceCount, opOtherScore);
                }
            }
        }
        if(pieceCount[1]===0){
            return _turn===0 ? -Infinity : Infinity;
        }
        if(opPieceCount[1]===0){
            return _turn===0 ? Infinity : -Infinity;
        }
        
        if(isQS){
            //dep = 0;//debug
            if(dep===0){
                return _turn===0 ?  evaluate(captureMove, otherMove, pieceCount, otherScore,
                                        opCaptureMove, opOtherMove, opPieceCount, opOtherScore)+2: 
                                        evaluate(opCaptureMove, opOtherMove, opPieceCount, opOtherScore,
                                        captureMove, otherMove, pieceCount, otherScore)-2;
            }else{//dep>0
                if(_turn===0){//engine
                    var length, i, bestValue = -Infinity, val;
                    length = captureMove.length;
                    for(i=0; i<length; i+=2){
                        prevValue = board[captureMove[i+1]];
                        board[captureMove[i+1]] = board[captureMove[i]];
                        board[captureMove[i]] = 0;
                        val = alphaBetaSearch(a, b, dep-1, true, false, true, _turn^8);
                        board[captureMove[i]] = board[captureMove[i+1]];
                        board[captureMove[i+1]] = prevValue;
                        if(val>bestValue){
                            bestValue = val;
                            if(isRoot){
                                bestMove[0] = captureMove[i];
                                bestMove[1] = captureMove[i+1];
                            }
                            a = max(a, bestValue);
                            if(a>=b){
                                return bestValue;
                            }
                        }
                    }
                    return bestValue;
                }else{//player
                    var length, i, bestValue = Infinity, val;
                    length = captureMove.length;
                    for(i=0; i<length; i+=2){
                        prevValue = board[captureMove[i+1]];
                        board[captureMove[i+1]] = board[captureMove[i]];
                        board[captureMove[i]] = 0;
                        val = alphaBetaSearch(a, b, dep-1, true, false, true, _turn^8);
                        board[captureMove[i]] = board[captureMove[i+1]];
                        board[captureMove[i+1]] = prevValue;
                        if(val<bestValue){
                            bestValue = val;
                            /*if(isRoot){ //player is always not root
                                bestMove[0] = captureMove[i];
                                bestMove[1] = captureMove[i+1];
                            }*/
                            b = min(b, bestValue);
                            if(b<=a){
                                return bestValue;
                            }
                        }
                    }
                    return bestValue;
                }// end - player
            }//end - dep > 0            
        }else{//not isQS
            if(dep===0){
                if(isCapture){
                    return min(alphaBetaSearch(a, b, depth-2, true, isRoot, true, _turn),
                    _turn===0 ?  evaluate(captureMove, otherMove, pieceCount, otherScore, 
                                        opCaptureMove, opOtherMove, opPieceCount, opOtherScore)+2: 
                                        evaluate(opCaptureMove, opOtherMove, opPieceCount, opOtherScore,
                                        captureMove, otherMove, pieceCount, otherScore)-2);// quiescence search
                }else{
                    return _turn===0 ?  evaluate(captureMove, otherMove, pieceCount, otherScore, 
                                        opCaptureMove, opOtherMove, opPieceCount, opOtherScore)+2: 
                                        evaluate(opCaptureMove, opOtherMove, opPieceCount, opOtherScore,
                                        captureMove, otherMove, pieceCount, otherScore)-2;
                }
            }else{//dep>0
                if(_turn===0){//engine
                    var length, i, bestValue = -Infinity, val;
                    length = captureMove.length;
                    for(i=0; i<length; i+=2){
                        prevValue = board[captureMove[i+1]];
                        board[captureMove[i+1]] = board[captureMove[i]];
                        board[captureMove[i]] = 0;
                        val = alphaBetaSearch(a, b, dep-1, false, false, true, _turn^8);
                        board[captureMove[i]] = board[captureMove[i+1]];
                        board[captureMove[i+1]] = prevValue;
                        if(val>bestValue){
                            bestValue = val;
                            if(isRoot){
                                bestMove[0] = captureMove[i];
                                bestMove[1] = captureMove[i+1];
                            }
                            a = max(a, bestValue);
                            if(a>=b){
                                return bestValue;
                            }
                        }
                    }
                    length = otherMove.length;
                    for(i=0; i<length; i+=2){
                        prevValue = board[otherMove[i+1]];
                        board[otherMove[i+1]] = board[otherMove[i]];
                        board[otherMove[i]] = 0;
                        val = alphaBetaSearch(a, b, dep-1, false, false, false, _turn^8);
                        board[otherMove[i]] = board[otherMove[i+1]];
                        board[otherMove[i+1]] = prevValue;
                        if(val>bestValue){
                            bestValue = val;
                            if(isRoot){
                                bestMove[0] = otherMove[i];
                                bestMove[1] = otherMove[i+1];
                            }
                            a = max(a, bestValue);
                            if(a>=b){
                                return bestValue;
                            }
                        }
                    }
                    return bestValue;
                }else{//player
                    var length, i, bestValue = Infinity, val;
                    length = captureMove.length;
                    for(i=0; i<length; i+=2){
                        prevValue = board[captureMove[i+1]];
                        board[captureMove[i+1]] = board[captureMove[i]];
                        board[captureMove[i]] = 0;
                        val = alphaBetaSearch(a, b, dep-1, false, false, true, _turn^8);
                        board[captureMove[i]] = board[captureMove[i+1]];
                        board[captureMove[i+1]] = prevValue;
                        if(val<bestValue){
                            bestValue = val;
                            /*if(isRoot){ //player is always not root
                                bestMove[0] = captureMove[i];
                                bestMove[1] = captureMove[i+1];
                            }*/
                            b = min(b, bestValue);
                            if(b<=a){
                                return bestValue;
                            }
                        }
                    }
                    length = otherMove.length;
                    for(i=0; i<length; i+=2){
                        prevValue = board[otherMove[i+1]];
                        board[otherMove[i+1]] = board[otherMove[i]];
                        board[otherMove[i]] = 0;
                        val = alphaBetaSearch(a, b, dep-1, false, false, false, _turn^8);
                        board[otherMove[i]] = board[otherMove[i+1]];
                        board[otherMove[i+1]] = prevValue;
                        if(val<bestValue){
                            bestValue = val;
                            /*if(isRoot){ player is always not root
                                bestMove[0] = captureMove[i];
                                bestMove[1] = captureMove[i+1];
                            }*/
                            b = min(b, bestValue);
                            if(b<=a){
                                return bestValue;
                            }
                        }
                    }
                    return bestValue;
                }// end - player
            }//end - dep > 0 
        }//end - not is QS
    }
    
    function drawBoard(){
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
        if(turn!==0 && bestMove.length>0){//player
            pieceCtx = pieceCanvas[bestMove[0]].getContext("2d");
            pieceCtx.drawImage(focusImg, -3, -3, cellSize+3, cellSize+3);
            pieceCtx = pieceCanvas[bestMove[1]].getContext("2d");
            pieceCtx.drawImage(focusImg, -3, -3, cellSize+3, cellSize+3);
            bestMove = [];
        }
    }
    function hideInfo(){
        infoCanvas.style.display = "none";
    }
    function showInfo(id){//id 0: lose, 1: win, 2: check
        var infoCtx, img;
        switch(id){
            case 0: img = loseImg; break;
            case 1: img = winImg; break;
            case 2: img = checkImg; break;
        }
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
        if(id===2){
            setTimeout(hideInfo, 700);
        }
    }
    function checkStatus(){
        var captureMove = [], otherMove = [], pieceCount = [0,0,0,0,0,0,0,0], otherScore = [0],
            kingPlayer = -1, i;
        for(var i =0; i<90; i++){
            if(board[i]!==0){
                if((board[i]&8)===0){
                    validMoveGen(i, captureMove, otherMove, pieceCount, otherScore);
                }else if(board[i]===9){
                    kingPlayer = i;
                }
            }
        }
        if(kingPlayer===-1){
            gameOver = true;
            showInfo(0);
            return 0;
        }else if(pieceCount[1]===0){
            gameOver = true;
            showInfo(1);
            return 1;
        }else{
            var length = captureMove.length;
            for(i=1; i< length; i+=2){
                if(captureMove[i]===kingPlayer){
                    showInfo(2);
                    return 2;
                }
            }
        }
        return -1;
    }
    function engineMove(){
        bestMove = [];
        alphaBetaSearch(-Infinity, Infinity, depth, false, true, false, turn);
        if(bestMove.length ===0 ){//không có nước đi 
            if(checkStatus()===-1){
                showInfo(1);
            }
            gameOver = true;
        }else{
            board[bestMove[1]] = board[bestMove[0]];
            board[bestMove[0]] = 0;
            turn = turn^8;
            checkStatus();
            drawBoard();
        }
    }
    function imageLoaded(){
        imageCount++;
        if(imageCount>=21){
            drawBoard();
        }
    }
    //PUBLIC API
    return {
        setDepth: function (d) {
            depth = d;
        },
        depthChange: function(){
            this.setDepth(depthCombobox.options[depthCombobox.selectedIndex].value);
        },
        reset: function(){
            board = [
            4, 6, 3, 2, 1, 2, 3, 6, 4,
            0, 0, 0, 0, 0, 0, 0, 0, 0,
            0, 5, 0, 0, 0, 0, 0, 5, 0,
            7, 0, 7, 0, 7, 0, 7, 0, 7,
            0, 0, 0, 0, 0, 0, 0, 0, 0,
            0, 0, 0, 0, 0, 0, 0, 0, 0,
           15, 0,15, 0,15, 0,15, 0,15,
            0,13, 0, 0, 0, 0, 0,13, 0,
            0, 0, 0, 0, 0, 0, 0, 0, 0,
           12,14,11,10, 9,10,11,14,12 
            ];
            turn = 8;
            gameOver = false;
            isCheck = false;
            focusedValidMove=[];
            focused = -1;
            infoCanvas.style.display = "none";
            drawBoard();
        },
        boardClicked: function(id){
            if(!gameOver && turn!==0){
                var piece = board[id];
                if(focused!==-1){
                    var i, length = focusedValidMove.length;
                    for(i=1; i<length; i+=2){
                        if(focusedValidMove[i]===id){
                            break;
                        }
                    }
                    if(i<length){//valid move
                        board[id] = board[focused];
                        board[focused] = 0;
                        focusedValidMove = [];
                        focused = -1;
                        turn = turn^8;
                        drawBoard();
                        setTimeout(engineMove, 1);
                    }else{//not valid move
                        if((piece&8) !== 0){
                            focused = id;
                            focusedValidMove = [];
                            var pieceCount = [0,0,0,0,0,0,0,0], otherScore=[0];//not use
                            validMoveGen(focused, focusedValidMove, focusedValidMove, pieceCount, otherScore);
                            drawBoard();
                       }else{
                            focused = -1;
                          focusedValidMove = [];
                          drawBoard();
                      }
                    }
                }else{//focused == -1
                    if((piece&8) !== 0){
                        focused = id;
                        focusedValidMove = [];
                        var pieceCount = [0,0,0,0,0,0,0,0], otherScore=[0];//not use
                        validMoveGen(focused, focusedValidMove, focusedValidMove, pieceCount, otherScore);
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
            
            cellSize = min((window.innerHeight*0.9)/10, (window.innerWidth*0.9)/9);
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
            infoCanvas.onclick = hideInfo;
            
            newGameButton = document.createElement("button");
            newGameButton.innerHTML = "New Game";
            newGameButton.setAttribute("onclick", "chess.reset();");
            
            depthCombobox = document.createElement("select");
            depthCombobox.innerHTML = "<option value=\"2\">2</option>\n\
                                       <option value=\"3\" selected>3</option>\n\
                                       <option value=\"4\">4</option>\n\
                                       <option value=\"5\">5</option>";
            depthCombobox.setAttribute("onchange", "chess.depthChange();");
            
            boardCanvas = document.createElement("canvas");
            boardCanvas.height = boardHeight;
            boardCanvas.width = boardWidth;
            boardCanvas.id = "boardCanvas";
            
            gameDiv.appendChild(infoCanvas);
            gameDiv.appendChild(boardCanvas);
            for(i=0; i<90; i++){
                pieceCanvas[i] = document.createElement("canvas");
                pieceCanvas[i].height = cellSize;
                pieceCanvas[i].width = cellSize;
                pieceCanvas[i].className="pieceCanvas";
                pieceCanvas[i].setAttribute("onclick", "chess.boardClicked("+i+")");
                gameDiv.appendChild(pieceCanvas[i]);
            }
            
            controlDiv.innerHTML = "Depth: ";
            controlDiv.appendChild(depthCombobox);
            controlDiv.appendChild(newGameButton);
            mainDiv.appendChild(controlDiv);
            mainDiv.appendChild(gameDiv);
            this.reset();
            imageLoaded();
        }
    };
}());
