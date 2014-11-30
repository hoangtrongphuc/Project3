

function Chess()
{
	this.board = [4, 6, 3, 2, 1, 2, 3, 6, 4,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 5, 0, 0, 0, 0, 0, 5, 0,
                7, 0, 7, 0, 7, 0, 7, 0, 7,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                17, 0,17, 0,17, 0,17, 0,17,
                0,15, 0, 0, 0, 0, 0,15, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                14,16,13,12, 11,12,13,16,14];
}



Chess.prototype.resetBoard = function(){
    var newBoard = [4, 6, 3, 2, 1, 2, 3, 6, 4,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 5, 0, 0, 0, 0, 0, 5, 0,
                7, 0, 7, 0, 7, 0, 7, 0, 7,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                17, 0,17, 0,17, 0,17, 0,17,
                0,15, 0, 0, 0, 0, 0,15, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                14,16,13,12, 11,12,13,16,14];
    for(var i = 0; i<90; i++){
        this.board[i] = newBoard[i];
    }
}

Chess.prototype.createBoard = function()
{
	var newBoard = [4, 6, 3, 2, 1, 2, 3, 6, 4,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 5, 0, 0, 0, 0, 0, 5, 0,
                7, 0, 7, 0, 7, 0, 7, 0, 7,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                17, 0,17, 0,17, 0,17, 0,17,
                0,15, 0, 0, 0, 0, 0,15, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                14,16,13,12, 11,12,13,16,14];
    return newBoard;
}

Chess.prototype.lookAt = function(row, col) {
    return this.board[row * 9 + col];
}

Chess.prototype.validMoveGen = function(id,  _captureMove, _otherMove) {
    var piece = this.board[id];
    if (piece === 0) return; 
    var col = id % 9;
    var row = (id - col) / 9;
    var piece_type = piece & 7;
    var piece_color = piece & 8;
    switch (piece_type) {
        case 1://tướng
            if (piece_color === 0) {//quân đen
                if (row > 0) {
                    if (lookAt( row - 1, col) === 0) {
                        _otherMove.push(id, (row-1)*9+col);
                    } else if ((lookAt( row - 1, col) & 8) !== piece_color) {
                       _captureMove.push(id, (row-1)*9+col);
                    }
                }
                if (row < 2) {
                    if (lookAt( row + 1, col) === 0) {
                        _otherMove.push(id,(row + 1)*9 + col);
                    } else if ((lookAt( row + 1, col) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 1)*9 + col);
                    }
                }
                if (col > 3) {
                    if (lookAt( row, col - 1) === 0) {
                        _otherMove.push(id,row * 9 + col - 1);
                    } else if ((lookAt( row, col - 1) & 8) !== piece_color) {
                        _captureMove.push(id,row * 9 + col - 1);
                    }
                }
                if (col < 5) {
                    if (lookAt( row, col + 1) === 0) {
                        _otherMove.push(id,row * 9 + col + 1);
                    } else if ((lookAt( row, col + 1) & 8) !== piece_color) {
                        _captureMove.push(id,row * 9 + col + 1);
                    }
                }
                //hở mặt tướng
                for (var i = row + 1; i < 10; i++) {
                    if (lookAt( i, col) !== 0) {
                        if (lookAt( i, col) === 9) {
                            _captureMove.push(id,i * 9 + col);
                        }
                        break;
                    }
                }
            } else {//quân đỏ
                if (row > 7) {
                    if (lookAt( row - 1, col) === 0) {
                        _otherMove.push(id,(row - 1)*9 + col);
                    } else if ((lookAt( row - 1, col) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 1)*9 + col);
                    }
                }
                if (row < 9) {
                    if (lookAt( row + 1, col) === 0) {
                        _otherMove.push(id,(row + 1)*9 + col);
                    } else if ((lookAt( row + 1, col) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 1)*9 + col);
                    }
                }
                if (col > 3) {
                    if (lookAt( row, col - 1) === 0) {
                        _otherMove.push(id,row * 9 + col - 1);
                    } else if ((lookAt( row, col - 1) & 8) !== piece_color) {
                        _captureMove.push(id,row * 9 + col - 1);
                    }
                }
                if (col < 5) {
                    if (lookAt( row, col + 1) === 0) {
                        _otherMove.push(id,row * 9 + col + 1);
                    } else if ((lookAt( row, col + 1) & 8) !== piece_color) {
                        _captureMove.push(id,row * 9 + col + 1);
                    }
                }
                //hở mặt tướng
                for (var i = row - 1; i >= 0; i--) {
                    if (lookAt( i, col) !== 0) {
                        if (lookAt( i, col) === 1) {
                            _captureMove.push(id,i * 9 + col);
                        }
                        break;
                    }
                }
            }
            break;
        case 2://sĩ
            if (piece_color === 0) {//quân đen
                if (row > 0 && col > 3) {
                    if (lookAt( row - 1, col - 1) === 0) {
                        _otherMove.push(id,(row - 1)*9 + col - 1);
                    } else if ((lookAt( row - 1, col - 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 1)*9 + col - 1);
                    }
                }
                if (row < 2 && col < 5) {
                    if (lookAt( row + 1, col + 1) === 0) {
                        _otherMove.push(id,(row + 1)*9 + col + 1);
                    } else if ((lookAt( row + 1, col + 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 1)*9 + col + 1);
                    }
                }
                if (row > 0 && col < 5) {
                    if (lookAt( row - 1, col + 1) === 0) {
                        _otherMove.push(id,(row - 1)*9 + col + 1);
                    } else if ((lookAt( row - 1, col + 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 1)*9 + col + 1);
                    }
                }
                if (row < 2 && col > 3) {
                    if (lookAt( row + 1, col - 1) === 0) {
                        _otherMove.push(id,(row + 1)*9 + col - 1);
                    } else if ((lookAt( row + 1, col - 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 1)*9 + col - 1);
                    }
                }
            } else {//quân đỏ
                if (row > 7 && col > 3) {
                    if (lookAt( row - 1, col - 1) === 0) {
                        _otherMove.push(id,(row - 1)*9 + col - 1);
                    } else if ((lookAt( row - 1, col - 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 1)*9 + col - 1);
                    }
                }
                if (row < 9 && col < 5) {
                    if (lookAt( row + 1, col + 1) === 0) {
                        _otherMove.push(id,(row + 1)*9 + col + 1);
                    } else if ((lookAt( row + 1, col + 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 1)*9 + col + 1);
                    }
                }
                if (row > 7 && col < 5) {
                    if (lookAt( row - 1, col + 1) === 0) {
                        _otherMove.push(id,(row - 1)*9 + col + 1);
                    } else if ((lookAt( row - 1, col + 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 1)*9 + col + 1);
                    }
                }
                if (row < 9 && col > 3) {
                    if (lookAt( row + 1, col - 1) === 0) {
                        _otherMove.push(id,(row + 1)*9 + col - 1);
                    } else if ((lookAt( row + 1, col - 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 1)*9 + col - 1);
                    }
                }
            }
            break;
        case 3://tượng
            if ( piece_color === 0) {//quân đen
                if (row > 0 && col > 0 && (lookAt( row - 1, col - 1) === 0)) {
                    if (lookAt( row - 2, col - 2) === 0) {
                        _otherMove.push(id,(row - 2)*9 + col - 2);
                    } else if ((lookAt( row - 2, col - 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 2)*9 + col - 2);
                    }
                }
                if (row < 4 && col < 8 && (lookAt( row + 1, col + 1) === 0)) {
                    if (lookAt( row + 2, col + 2) === 0) {
                        _otherMove.push(id,(row + 2)*9 + col + 2);
                    } else if ((lookAt( row + 2, col + 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 2)*9 + col + 2);
                    }
                }
                if (row > 0 && col < 8 && (lookAt( row - 1, col + 1) === 0)) {
                    if (lookAt( row - 2, col + 2) === 0) {
                        _otherMove.push(id,(row - 2)*9 + col + 2);
                    } else if ((lookAt( row - 2, col + 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 2)*9 + col + 2);
                    }
                }
                if (row < 4 && col > 0 && (lookAt( row + 1, col - 1) === 0)) {
                    if (lookAt( row + 2, col - 2) === 0) {
                        _otherMove.push(id,(row + 2)*9 + col - 2);
                    } else if ((lookAt( row + 2, col - 2) & 8) !== piece_color) {
                        _otherMove.push(id,(row + 2)*9 + col - 2);
                    }
                }
            } else {//quân đỏ
                if (row > 5 && col > 0 && (lookAt( row - 1, col - 1) === 0)) {
                    if (lookAt( row - 2, col - 2) === 0) {
                        _otherMove.push(id,(row - 2)*9 + col - 2);
                    } else if ((lookAt( row - 2, col - 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 2)*9 + col - 2);
                    }
                }
                if (row < 9 && col < 8 && (lookAt( row + 1, col + 1) === 0)) {
                    if (lookAt( row + 2, col + 2) === 0) {
                        _otherMove.push(id,(row + 2)*9 + col + 2);
                    } else if ((lookAt( row + 2, col + 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 2)*9 + col + 2);
                    }
                }
                if (row > 5 && col < 8 && (lookAt( row - 1, col + 1) === 0)) {
                    if (lookAt( row - 2, col + 2) === 0) {
                        _otherMove.push(id,(row - 2)*9 + col + 2);
                    } else if ((lookAt( row - 2, col + 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 2)*9 + col + 2);
                    }
                }
                if (row < 9 && col > 0 && (lookAt( row + 1, col - 1) === 0)) {
                    if (lookAt( row + 2, col - 2) === 0) {
                        _otherMove.push(id,(row + 2)*9 + col - 2);
                    } else if ((lookAt( row + 2, col - 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 2)*9 + col - 2);
                    }
                }
            }
            break;
        case 4://xe
            for (var i = col + 1; i < 9; i++) {
                if (lookAt( row, i) === 0) {
                    _otherMove.push(id,row * 9 + i);
                } else {
                    if ((lookAt( row, i) & 8) !== piece_color) {
                        _captureMove.push(id,row * 9 + i);
                    }
                    break;
                }
            }
            for (var i = col - 1; i >= 0; i--) {
                if (lookAt( row, i) === 0) {
                    _otherMove.push(id,row * 9 + i);
                } else {
                    if ((lookAt( row, i) & 8) !== piece_color) {
                        _captureMove.push(id,row * 9 + i);
                    }
                    break;
                }
            }
            for (var i = row + 1; i < 10; i++) {
                if (lookAt( i, col) === 0) {
                    _otherMove.push(id,i * 9 + col);
                } else {
                    if ((lookAt( i, col) & 8) !== piece_color) {
                        _captureMove.push(id,i * 9 + col);
                    }
                    break;
                }
            }
            for (var i = row - 1; i >= 0; i--) {
                if (lookAt( i, col) === 0) {
                    _otherMove.push(id,i * 9 + col);
                } else {
                    if ((lookAt( i, col) & 8) !== piece_color) {
                        _captureMove.push(id,i * 9 + col);
                    }
                    break;
                }
            }
            break;
        case 5://pháo
            for (var i = col + 1; i < 9; i++) {
                if (lookAt( row, i) === 0) {
                    _otherMove.push(id,row * 9 + i);
                } else {
                    for (var j = i + 1; j < 9; j++) {
                        if (lookAt( row, j) !== 0) {
                            if ((lookAt( row, j) & 8) !== piece_color) {
                                _captureMove.push(id,row * 9 + j);
                            }
                            break;
                        }
                    }
                    break;
                }
            }
            for (var i = col - 1; i >= 0; i--) {
                if (lookAt( row, i) === 0) {
                    _otherMove.push(id,row * 9 + i);
                } else {
                    for (var j = i - 1; j >= 0; j--) {
                        if (lookAt( row, j) !== 0) {
                            if ((lookAt( row, j) & 8) !== piece_color) {
                                _captureMove.push(id,row * 9 + j);
                            }
                            break;
                        }
                    }
                    break;
                }
            }
            for (var i = row + 1; i < 10; i++) {
                if (lookAt( i, col) === 0) {
                    _otherMove.push(id,i * 9 + col);
                } else {
                    for (var j = i + 1; j < 10; j++) {
                        if (lookAt( j, col) !== 0) {
                            if ((lookAt( j, col) & 8) !== piece_color) {
                                _captureMove.push(id,j * 9 + col);
                            }
                            break;
                        }
                    }
                    break;
                }
            }
            for (var i = row - 1; i >= 0; i--) {
                if (lookAt( i, col) === 0) {
                    _otherMove.push(id,i * 9 + col);
                } else {
                    for (var j = i - 1; j >= 0; j--) {
                        if (lookAt( j, col) !== 0) {
                            if ((lookAt( j, col) & 8) !== piece_color) {
                                _captureMove.push(id,j * 9 + col);
                            }
                            break;
                        }
                    }
                    break;
                }
            }
            break;
        case 6://mã
            if (row > 1 && lookAt( row - 1, col) === 0) {//không bị cản phía trên
                if (col > 0) {
                    if (lookAt( row - 2, col - 1) === 0) {
                        _otherMove.push(id,(row - 2) * 9 + col - 1);
                    } else if ((lookAt( row - 2, col - 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 2) * 9 + col - 1);
                    }
                }
                if (col < 8) {
                    if (lookAt( row - 2, col + 1) === 0) {
                        _otherMove.push(id,(row - 2) * 9 + col + 1);
                    } else if ((lookAt( row - 2, col + 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 2) * 9 + col + 1);
                    }
                }
            }
            if (row < 8 && lookAt( row + 1, col) === 0) {//không bị cản phía dưới
                if (col > 0) {
                    if (lookAt( row + 2, col - 1) === 0) {
                        _otherMove.push(id,(row + 2) * 9 + col - 1);
                    } else if ((lookAt( row + 2, col - 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 2) * 9 + col - 1);
                    }
                }
                if (col < 8) {
                    if (lookAt( row + 2, col + 1) === 0) {
                        _otherMove.push(id,(row + 2) * 9 + col + 1);
                    } else if ((lookAt( row + 2, col + 1) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 2) * 9 + col + 1);
                    }
                }
            }
            if (col > 1 && lookAt( row, col - 1) === 0) {//không bị cản phía trái
                if (row > 0) {
                    if (lookAt( row - 1, col - 2) === 0) {
                        _otherMove.push(id,(row - 1) * 9 + col - 2);
                    } else if ((lookAt( row - 1, col - 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 1) * 9 + col - 2);
                    }
                }
                if (row < 9) {
                    if (lookAt( row + 1, col - 2) === 0) {
                        _otherMove.push(id,(row + 1) * 9 + col - 2);
                    } else if ((lookAt( row + 1, col - 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 1) * 9 + col - 2);
                    }
                }
            }
            if (col < 7 && lookAt( row, col + 1) === 0) {//không bị cản phía phải
                if (row > 0) {
                    if (lookAt( row - 1, col + 2) === 0) {
                        _otherMove.push(id,(row - 1) * 9 + col + 2);
                    } else if ((lookAt( row - 1, col + 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 1) * 9 + col + 2);
                    }
                }
                if (row < 9) {
                    if (lookAt( row + 1, col + 2) === 0) {
                        _otherMove.push(id,(row + 1) * 9 + col + 2);
                    } else if ((lookAt( row + 1, col + 2) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 1) * 9 + col + 2);
                    }
                }
            }
            break;
        case 7://tốt
            if (piece_color === 0) {//quân đen
                if (row < 9) {
                    if (lookAt( row + 1, col) === 0) {
                        _otherMove.push(id,(row + 1)*9 + col);
                    } else if ((lookAt( row + 1, col) & 8) !== piece_color) {
                        _captureMove.push(id,(row + 1)*9 + col);
                    }
                }
                if (row > 4) {//đã sang sông
                    if (col < 8) {
                        if (lookAt( row, col + 1) === 0) {
                            _otherMove.push(id,row * 9 + col + 1);
                        } else if ((lookAt( row, col + 1) & 8) !== piece_color) {
                            _captureMove.push(id,row * 9 + col + 1);
                        }
                    }
                    if (col > 0) {
                        if (lookAt( row, col - 1) === 0) {
                            _otherMove.push(id,row * 9 + col - 1);
                        } else if ((lookAt( row, col - 1) & 8) !== piece_color) {
                            _captureMove.push(id,row * 9 + col - 1);
                        }
                    }
                }
            } else {//quân đỏ
                if (row > 0) {
                    if (lookAt( row - 1, col) === 0) {
                        _otherMove.push(id,(row - 1)*9 + col);
                    } else if ((lookAt( row - 1, col) & 8) !== piece_color) {
                        _captureMove.push(id,(row - 1)*9 + col);
                    }
                }
                if (row < 5) {//đã sang sông
                    if (col < 8) {
                        if (lookAt( row, col + 1) === 0) {
                            _otherMove.push(id,row * 9 + col + 1);
                        } else if ((lookAt( row, col + 1) & 8) !== piece_color) {
                            _captureMove.push(id,row * 9 + col + 1);
                        }
                    }
                    if (col > 0) {
                        if (lookAt( row, col - 1) === 0) {
                            _otherMove.push(id,row * 9 + col - 1);
                        } else if ((lookAt( row, col - 1) & 8) !== piece_color) {
                            _captureMove.push(id,row * 9 + col - 1);
                        }
                    }
                }
            }
            break;
    }
}

Chess.prototype.isValidMove = function(id1, id2) {
    var otherMove;
    var captureMove;
    validMoveGen(id1, otherMove, captureMove);
    for (var i = 1; i < otherMove.length; i += 2) {
        if (otherMove[i] === id2) {
            return true;
        }
    }
    for (var i = 1; i < captureMove.length; i += 2) {
        if (captureMove[i] === id2) {
            return true;
        }
    }
    return false;
}

Chess.prototype.checkStatus = function() {
    var redCaptureMove, redOtherMove, blackCaptureMove, blackOtherMove;
    var redGeneral = - 1;
    var blackGeneral = -1;
    var i;
    for (i = 0; i < 90; i++) {
        if (this.board[i] !== 0) {
            if ((this.board[i] & 8) === 0) {//black
                validMoveGen(i, blackCaptureMove, blackOtherMove);
                if ((this.board[i] & 7) === 1) {
                    blackGeneral = i;
                }
            } else {//red
                validMoveGen(i, redCaptureMove, redOtherMove);
                if ((this.board[i] & 7) === 1) {
                    redGeneral = i;
                }
            }
        }
    }
    if (blackGeneral === -1) {
        return 2; //red win
    }
    if (redGeneral === -1) {
        return -2; //black win
    }
    for (i = 1; i < redCaptureMove.length; i += 2) {
        if (redCaptureMove[i] === blackGeneral) {
            return 1; //red check
        }
    }
    for (i = 1; i < blackCaptureMove.length; i += 2) {
        if (blackCaptureMove[i] === redGeneral) {
            return -1; //black check
        }
    }
    return 0; //normal
}


Chess.prototype.resetBoard = function(){
    var newBoard = [4, 6, 3, 2, 1, 2, 3, 6, 4,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 5, 0, 0, 0, 0, 0, 5, 0,
                7, 0, 7, 0, 7, 0, 7, 0, 7,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                15, 0,15, 0,15, 0,15, 0,15,
                0,13, 0, 0, 0, 0, 0,13, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                12,14,11,10, 9,10,11,14,12];
    for(var i = 0; i<90; i++){
        this.board[i] = newBoard[i];
    }
}

Chess.prototype.createBoard = function()
{
	var newBoard = [4, 6, 3, 2, 1, 2, 3, 6, 4,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 5, 0, 0, 0, 0, 0, 5, 0,
                7, 0, 7, 0, 7, 0, 7, 0, 7,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                15, 0,15, 0,15, 0,15, 0,15,
                0,13, 0, 0, 0, 0, 0,13, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                12,14,11,10, 9,10,11,14,12];
    return newBoard;
}

Chess.prototype.chessMove = function(r1, c1, r2, c2)
{
    this.board[r2*9+c2] = this.board[r1*9+c1];
    this.board[r1*9+c1] = 0;
}

Chess.prototype.chessMove = function(id1,id2)
{
    this.board[id2] = this.board[id1];
    this.board[id1] = 0;
}

module.exports = Chess;
