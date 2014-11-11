

function lookAt(board, int row, int col) {
    return board[row * 9 + col];
}

function validMoveGen(board, id,  _captureMove, _otherMove) {
    var piece = board[id];
    if (piece === 0) return; 
    var col = id % 9;
    var row = (id - col) / 9;
    var piece_type = piece % 10;
    var piece_color = piece / 10;
    switch (piece_type) {
        case 1://tướng
            if (piece_color === 0) {//quân đen
                if (row > 0) {
                    if (lookAt(board, row - 1, col) === 0) {
                        _otherMove.push(id, (row-1)*9+col);
                    } else if ((lookAt(board, row - 1, col) / 10) !== piece_color) {
                       _captureMove.push(id, (row-1)*9+col);
                    }
                }
                if (row < 2) {
                    if (lookAt(board, row + 1, col) === 0) {
                        _otherMove.push(id,(row + 1)*9 + col);
                    } else if ((lookAt(board, row + 1, col) / 10) !== piece_color) {
                        _captureMove.push(id,(row + 1)*9 + col);
                    }
                }
                if (col > 3) {
                    if (lookAt(board, row, col - 1) === 0) {
                        _otherMove.push(id,row * 9 + col - 1);
                    } else if ((lookAt(board, row, col - 1) / 10) !== piece_color) {
                        _captureMove.push(id,row * 9 + col - 1);
                    }
                }
                if (col < 5) {
                    if (lookAt(board, row, col + 1) === 0) {
                        _otherMove.push(id,row * 9 + col + 1);
                    } else if ((lookAt(board, row, col + 1) / 10) !== piece_color) {
                        _captureMove.push(id,row * 9 + col + 1);
                    }
                }
                //hở mặt tướng
                for (int i = row + 1; i < 10; i++) {
                    if (lookAt(board, i, col) !== 0) {
                        if (lookAt(board, i, col) === 9) {
                            _captureMove.push(id,i * 9 + col);
                        }
                        break;
                    }
                }
            } else {//quân đỏ
                if (row > 7) {
                    if (lookAt(board, row - 1, col) === 0) {
                        
                        _otherMove.push(id,(row - 1)*9 + col);
                    } else if ((lookAt(board, row - 1, col) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 1)*9 + col);
                    }
                }
                if (row < 9) {
                    if (lookAt(board, row + 1, col) === 0) {
                        
                        _otherMove.push(id,(row + 1)*9 + col);
                    } else if ((lookAt(board, row + 1, col) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row + 1)*9 + col);
                    }
                }
                if (col > 3) {
                    if (lookAt(board, row, col - 1) === 0) {
                        
                        _otherMove.push(id,row * 9 + col - 1);
                    } else if ((lookAt(board, row, col - 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,row * 9 + col - 1);
                    }
                }
                if (col < 5) {
                    if (lookAt(board, row, col + 1) === 0) {
                        
                        _otherMove.push(id,row * 9 + col + 1);
                    } else if ((lookAt(board, row, col + 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,row * 9 + col + 1);
                    }
                }
                //hở mặt tướng
                for (int i = row - 1; i >= 0; i--) {
                    if (lookAt(board, i, col) !== 0) {
                        if (lookAt(board, i, col) === 1) {
                            
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
                    if (lookAt(board, row - 1, col - 1) === 0) {
                        
                        _otherMove.push(id,(row - 1)*9 + col - 1);
                    } else if ((lookAt(board, row - 1, col - 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 1)*9 + col - 1);
                    }
                }
                if (row < 2 && col < 5) {
                    if (lookAt(board, row + 1, col + 1) === 0) {
                        
                        _otherMove.push(id,(row + 1)*9 + col + 1);
                    } else if ((lookAt(board, row + 1, col + 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row + 1)*9 + col + 1);
                    }
                }
                if (row > 0 && col < 5) {
                    if (lookAt(board, row - 1, col + 1) === 0) {
                        
                        _otherMove.push(id,(row - 1)*9 + col + 1);
                    } else if ((lookAt(board, row - 1, col + 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 1)*9 + col + 1);
                    }
                }
                if (row < 2 && col > 3) {
                    if (lookAt(board, row + 1, col - 1) === 0) {
                        
                        _otherMove.push(id,(row + 1)*9 + col - 1);
                    } else if ((lookAt(board, row + 1, col - 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row + 1)*9 + col - 1);
                    }
                }
            } else {//quân đỏ
                if (row > 7 && col > 3) {
                    if (lookAt(board, row - 1, col - 1) === 0) {
                        
                        _otherMove.push(id,(row - 1)*9 + col - 1);
                    } else if ((lookAt(board, row - 1, col - 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 1)*9 + col - 1);
                    }
                }
                if (row < 9 && col < 5) {
                    if (lookAt(board, row + 1, col + 1) === 0) {
                        
                        _otherMove.push(id,(row + 1)*9 + col + 1);
                    } else if ((lookAt(board, row + 1, col + 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row + 1)*9 + col + 1);
                    }
                }
                if (row > 7 && col < 5) {
                    if (lookAt(board, row - 1, col + 1) === 0) {
                        
                        _otherMove.push(id,(row - 1)*9 + col + 1);
                    } else if ((lookAt(board, row - 1, col + 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 1)*9 + col + 1);
                    }
                }
                if (row < 9 && col > 3) {
                    if (lookAt(board, row + 1, col - 1) === 0) {
                        
                        _otherMove.push(id,(row + 1)*9 + col - 1);
                    } else if ((lookAt(board, row + 1, col - 1) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row + 1)*9 + col - 1);
                    }
                }
            }
            break;
        case 3://tượng
            if ( piece_color === 0) {//quân đen
                if (row > 0 && col > 0 && (lookAt(board, row - 1, col - 1) === 0)) {
                    if (lookAt(board, row - 2, col - 2) === 0) {
                        
                        _otherMove.push(id,(row - 2)*9 + col - 2);
                    } else if ((lookAt(board, row - 2, col - 2) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 2)*9 + col - 2);
                    }
                }
                if (row < 4 && col < 8 && (lookAt(board, row + 1, col + 1) === 0)) {
                    if (lookAt(board, row + 2, col + 2) === 0) {
                        
                        _otherMove.push(id,(row + 2)*9 + col + 2);
                    } else if ((lookAt(board, row + 2, col + 2) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row + 2)*9 + col + 2);
                    }
                }
                if (row > 0 && col < 8 && (lookAt(board, row - 1, col + 1) === 0)) {
                    if (lookAt(board, row - 2, col + 2) === 0) {
                        
                        _otherMove.push(id,(row - 2)*9 + col + 2);
                    } else if ((lookAt(board, row - 2, col + 2) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 2)*9 + col + 2);
                    }
                }
                if (row < 4 && col > 0 && (lookAt(board, row + 1, col - 1) === 0)) {
                    if (lookAt(board, row + 2, col - 2) === 0) {
                        
                        _otherMove.push(id,(row + 2)*9 + col - 2);
                    } else if ((lookAt(board, row + 2, col - 2) / 10) !== piece_color) {
                        
                        _otherMove.push(id,(row + 2)*9 + col - 2);
                    }
                }
            } else {//quân đỏ
                if (row > 5 && col > 0 && (lookAt(board, row - 1, col - 1) === 0)) {
                    if (lookAt(board, row - 2, col - 2) === 0) {
                        
                        _otherMove.push(id,(row - 2)*9 + col - 2);
                    } else if ((lookAt(board, row - 2, col - 2) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 2)*9 + col - 2);
                    }
                }
                if (row < 9 && col < 8 && (lookAt(board, row + 1, col + 1) === 0)) {
                    if (lookAt(board, row + 2, col + 2) === 0) {
                        
                        _otherMove.push(id,(row + 2)*9 + col + 2);
                    } else if ((lookAt(board, row + 2, col + 2) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row + 2)*9 + col + 2);
                    }
                }
                if (row > 5 && col < 8 && (lookAt(board, row - 1, col + 1) === 0)) {
                    if (lookAt(board, row - 2, col + 2) === 0) {
                        
                        _otherMove.push(id,(row - 2)*9 + col + 2);
                    } else if ((lookAt(board, row - 2, col + 2) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 2)*9 + col + 2);
                    }
                }
                if (row < 9 && col > 0 && (lookAt(board, row + 1, col - 1) === 0)) {
                    if (lookAt(board, row + 2, col - 2) === 0) {
                        
                        _otherMove.push(id,(row + 2)*9 + col - 2);
                    } else if ((lookAt(board, row + 2, col - 2) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row + 2)*9 + col - 2);
                    }
                }
            }
            break;
        case 4://xe
            for (int i = col + 1; i < 9; i++) {
                if (lookAt(board, row, i) === 0) {
                    
                    _otherMove.push(id,row * 9 + i);
                } else {
                    if ((lookAt(board, row, i) / 10) !== piece_color) {
                        
                        _captureMove.push(id,row * 9 + i);
                    }
                    break;
                }
            }
            for (int i = col - 1; i >= 0; i--) {
                if (lookAt(board, row, i) === 0) {
                    
                    _otherMove.push(id,row * 9 + i);
                } else {
                    if ((lookAt(board, row, i) / 10) !== piece_color) {
                        
                        _captureMove.push(id,row * 9 + i);
                    }
                    break;
                }
            }
            for (int i = row + 1; i < 10; i++) {
                if (lookAt(board, i, col) === 0) {
                    
                    _otherMove.push(id,i * 9 + col);
                } else {
                    if ((lookAt(board, i, col) / 10) !== piece_color) {
                        
                        _captureMove.push(id,i * 9 + col);
                    }
                    break;
                }
            }
            for (int i = row - 1; i >= 0; i--) {
                if (lookAt(board, i, col) === 0) {
                    
                    _otherMove.push(id,i * 9 + col);
                } else {
                    if ((lookAt(board, i, col) / 10) !== piece_color) {
                        
                        _captureMove.push(id,i * 9 + col);
                    }
                    break;
                }
            }
            break;
        case 5://pháo
            for (int i = col + 1; i < 9; i++) {
                if (lookAt(board, row, i) === 0) {
                    
                    _otherMove.push(id,row * 9 + i);
                } else {
                    for (int j = i + 1; j < 9; j++) {
                        if (lookAt(board, row, j) !== 0) {
                            if ((lookAt(board, row, j) / 10) !== piece_color) {
                                
                                _captureMove.push(id,row * 9 + j);
                            }
                            break;
                        }
                    }
                    break;
                }
            }
            for (int i = col - 1; i >= 0; i--) {
                if (lookAt(board, row, i) === 0) {
                    
                    _otherMove.push(id,row * 9 + i);
                } else {
                    for (int j = i - 1; j >= 0; j--) {
                        if (lookAt(board, row, j) !== 0) {
                            if ((lookAt(board, row, j) / 10) !== piece_color) {
                                
                                _captureMove.push(id,row * 9 + j);
                            }
                            break;
                        }
                    }
                    break;
                }
            }
            for (int i = row + 1; i < 10; i++) {
                if (lookAt(board, i, col) === 0) {
                    
                    _otherMove.push(id,i * 9 + col);
                } else {
                    for (int j = i + 1; j < 10; j++) {
                        if (lookAt(board, j, col) !== 0) {
                            if ((lookAt(board, j, col) / 10) !== piece_color) {
                                
                                _captureMove.push(id,j * 9 + col);
                            }
                            break;
                        }
                    }
                    break;
                }
            }
            for (int i = row - 1; i >= 0; i--) {
                if (lookAt(board, i, col) === 0) {
                    
                    _otherMove.push(id,i * 9 + col);
                } else {
                    for (int j = i - 1; j >= 0; j--) {
                        if (lookAt(board, j, col) !== 0) {
                            if ((lookAt(board, j, col) / 10) !== piece_color) {
                                
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
            if (row > 1 && lookAt(board, row - 1, col) === 0) {//không bị cản phía trên
                if (col > 0) {
                    if (lookAt(board, row - 2, col - 1) === 0) {
                        
                        _otherMove.push(id,(row - 2) * 9 + col - 1);
                    } else if ((lookAt(board, row - 2, col - 1) & 8) !== piece_color) {
                        
                        _captureMove.push(id,(row - 2) * 9 + col - 1);
                    }
                }
                if (col < 8) {
                    if (lookAt(board, row - 2, col + 1) === 0) {
                        
                        _otherMove.push(id,(row - 2) * 9 + col + 1);
                    } else if ((lookAt(board, row - 2, col + 1) & 8) !== piece_color) {
                        
                        _captureMove.push(id,(row - 2) * 9 + col + 1);
                    }
                }
            }
            if (row < 8 && lookAt(board, row + 1, col) === 0) {//không bị cản phía dưới
                if (col > 0) {
                    if (lookAt(board, row + 2, col - 1) === 0) {
                        
                        _otherMove.push(id,(row + 2) * 9 + col - 1);
                    } else if ((lookAt(board, row + 2, col - 1) & 8) !== piece_color) {
                        
                        _captureMove.push(id,(row + 2) * 9 + col - 1);
                    }
                }
                if (col < 8) {
                    if (lookAt(board, row + 2, col + 1) === 0) {
                        
                        _otherMove.push(id,(row + 2) * 9 + col + 1);
                    } else if ((lookAt(board, row + 2, col + 1) & 8) !== piece_color) {
                        
                        _captureMove.push(id,(row + 2) * 9 + col + 1);
                    }
                }
            }
            if (col > 1 && lookAt(board, row, col - 1) === 0) {//không bị cản phía trái
                if (row > 0) {
                    if (lookAt(board, row - 1, col - 2) === 0) {
                        
                        _otherMove.push(id,(row - 1) * 9 + col - 2);
                    } else if ((lookAt(board, row - 1, col - 2) & 8) !== piece_color) {
                        
                        _captureMove.push(id,(row - 1) * 9 + col - 2);
                    }
                }
                if (row < 9) {
                    if (lookAt(board, row + 1, col - 2) === 0) {
                        
                        _otherMove.push(id,(row + 1) * 9 + col - 2);
                    } else if ((lookAt(board, row + 1, col - 2) & 8) !== piece_color) {
                        
                        _captureMove.push(id,(row + 1) * 9 + col - 2);
                    }
                }
            }
            if (col < 7 && lookAt(board, row, col + 1) === 0) {//không bị cản phía phải
                if (row > 0) {
                    if (lookAt(board, row - 1, col + 2) === 0) {
                        
                        _otherMove.push(id,(row - 1) * 9 + col + 2);
                    } else if ((lookAt(board, row - 1, col + 2) & 8) !== piece_color) {
                        
                        _captureMove.push(id,(row - 1) * 9 + col + 2);
                    }
                }
                if (row < 9) {
                    if (lookAt(board, row + 1, col + 2) === 0) {
                        
                        _otherMove.push(id,(row + 1) * 9 + col + 2);
                    } else if ((lookAt(board, row + 1, col + 2) & 8) !== piece_color) {
                        
                        _captureMove.push(id,(row + 1) * 9 + col + 2);
                    }
                }
            }
            break;
        case 7://tốt
            if (piece_color === 0) {//quân đen
                if (row < 9) {
                    if (lookAt(board, row + 1, col) === 0) {
                        
                        _otherMove.push(id,(row + 1)*9 + col);
                    } else if ((lookAt(board, row + 1, col) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row + 1)*9 + col);
                    }
                }
                if (row > 4) {//đã sang sông
                    if (col < 8) {
                        if (lookAt(board, row, col + 1) === 0) {
                            
                            _otherMove.push(id,row * 9 + col + 1);
                        } else if ((lookAt(board, row, col + 1) / 10) !== piece_color) {
                            
                            _captureMove.push(id,row * 9 + col + 1);
                        }
                    }
                    if (col > 0) {
                        if (lookAt(board, row, col - 1) === 0) {
                            
                            _otherMove.push(id,row * 9 + col - 1);
                        } else if ((lookAt(board, row, col - 1) / 10) !== piece_color) {
                            
                            _captureMove.push(id,row * 9 + col - 1);
                        }
                    }
                }
            } else {//quân đỏ
                if (row > 0) {
                    if (lookAt(board, row - 1, col) === 0) {
                        
                        _otherMove.push(id,(row - 1)*9 + col);
                    } else if ((lookAt(board, row - 1, col) / 10) !== piece_color) {
                        
                        _captureMove.push(id,(row - 1)*9 + col);
                    }
                }
                if (row < 5) {//đã sang sông
                    if (col < 8) {
                        if (lookAt(board, row, col + 1) === 0) {
                            
                            _otherMove.push(id,row * 9 + col + 1);
                        } else if ((lookAt(board, row, col + 1) / 10) !== piece_color) {
                            
                            _captureMove.push(id,row * 9 + col + 1);
                        }
                    }
                    if (col > 0) {
                        if (lookAt(board, row, col - 1) === 0) {
                            
                            _otherMove.push(id,row * 9 + col - 1);
                        } else if ((lookAt(board, row, col - 1) / 10) !== piece_color) {
                            
                            _captureMove.push(id,row * 9 + col - 1);
                        }
                    }
                }
            }
            break;
    }
}

function isValidMove(board, id1, id2) {
    var otherMove;
    var captureMove;
    validMoveGen(board, id1, otherMove, captureMove);
    for (int i = 1; i < otherMove.size(); i += 2) {
        if (otherMove[i] === id2) {
            return true;
        }
    }
    for (int i = 1; i < captureMove.size(); i += 2) {
        if (captureMove[i] === id2) {
            return true;
        }
    }
    return false;
}

int checkStatus(const int* board) {
    vector<int> redCaptureMove, redOtherMove, blackCaptureMove, blackOtherMove;
    int redGeneral = - 1;
    int blackGeneral = -1;
    int i;
    for (i = 0; i < 90; i++) {
        if (board[i] !== 0) {
            if ((board[i] / 10) === 0) {//black
                validMoveGen(board, i, blackCaptureMove, blackOtherMove);
                if (board[i] % 10 === 1) {
                    blackGeneral = i;
                }
            } else {//red
                validMoveGen(board, i, redCaptureMove, redOtherMove);
                if (board[i] % 10 === 1) {
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
    for (i = 1; i < redCaptureMove.size(); i += 2) {
        if (redCaptureMove[i] === blackGeneral) {
            return 1; //red check
        }
    }
    for (i = 1; i < blackCaptureMove.size(); i += 2) {
        if (blackCaptureMove[i] === redGeneral) {
            return -1; //black check
        }
    }
    return 0; //normal
}

int checkStatus(const int board[10][9]) {
    return checkStatus((int*) board);
}

function resetBoard(board[]){
    int newBoard[] = {4, 6, 3, 2, 1, 2, 3, 6, 4,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 5, 0, 0, 0, 0, 0, 5, 0,
                7, 0, 7, 0, 7, 0, 7, 0, 7,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                17, 0,17, 0,17, 0,17, 0,17,
                0,15, 0, 0, 0, 0, 0,15, 0,
                0, 0, 0, 0, 0, 0, 0, 0, 0,
                14,16,13,12, 11,12,13,16,14};
    for(int i = 0; i<90; i++){
        board[i] = newBoard[i];
    }
}

void resetBoard(int board[10][9]){
    resetBoard((int*)board);
}

void chessMove(int* board, int r1, int c1, int r2, int c2){
    board[r2*9+c2] = board[r1*9+c1];
    board[r1*9+c1] = 0;
}

void chessMove(int board[10][9], int r1, int c1, int r2, int c2){
    board[r2][c2] = board[r1][c1];
    board[r1][c1] = 0;
}