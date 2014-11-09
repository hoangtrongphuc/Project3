BLOCK_COLOUR_1="#2eccfa";
BLOCK_COLOUR_2="#ccccfa";
BLOCK_SIZE_H=0;
BLOCK_SIZE_W=0;
offsetX=25;
offsetY=25;
//data  0    1    2     3     4      5      6     7
pieces=["","tot","ma","si","phao","tuongj","xe","tuongs"];
sides=['do','den'];
data = [

{
x:0,
y:3,
p:1
},
{
x:2,
y:3,
p:1
},
{
x:4,
y:3,
p:1
},
{
x:6,
y:3,
p:1
},
{
x:8,
y:3,
p:1
},
{
x:1,
y:0,
p:2
},
{
x:7,
y:0,
p:2
},
{
x:2,
y:0,
p:3
},
{
x:6,
y:0,
p:3
},
{
x:1,
y:2,
p:4
},
{
x:7,
y:2,
p:4
},
{
x:3,
y:0,
p:5
},
{
x:5,
y:0,
p:5
},
{
x:0,
y:0,
p:6
},
{
x:8,
y:0,
p:6
},
{
x:4,
y:0,
p:7
},
{
x:0,
y:6,
p:11
}
,
{
x:2,
y:6,
p:11
}
,
{
x:4,
y:6,
p:11
}
,
{
x:6,
y:6,
p:11
}
,
{
x:8,
y:6,
p:11
}
,
{
x:1,
y:7,
p:14
}
,
{
x:7,
y:7,
p:14
}
,
{
x:0,
y:9,
p:16
}
,
{
x:1,
y:9,
p:12
}
,
{
x:2,
y:9,
p:15
},
{
x:3,
y:9,
p:13
},
{
x:4,
y:9,
p:17
}
,
{
x:5,
y:9,
p:13
}
,
{
x:6,
y:9,
p:15
}
,
{
x:7,
y:9,
p:12
}
,
{
x:8,
y:9,
p:16

}
]
//end_data
function render()
{
canvas = document.getElementById('chess');
 if(canvas.getContext)
    {
		NUMBER_OF_ROWS = 9;
		NUMBER_OF_COLS = 8;
        ctx = canvas.getContext('2d');
 
        // Calculdate the precise block size
        BLOCK_SIZE_H = (canvas.height-2*offsetY) / NUMBER_OF_ROWS;
        BLOCK_SIZE_W = (canvas.width-2*offsetX) / NUMBER_OF_COLS;
        // Draw the background
        drawBoard();
 
        //defaultPositions();
        placePieces();
        // Draw pieces
        //pieces = new Image();
       // pieces.src = 'pieces.png';
       // pieces.onload = drawPieces;
 
      //  canvas.addEventListener('click', board_click, false);
    }
    else
    {
        alert("Canvas not supported!");
    }
}
function drawBoard()
{   
    for(iRowCounter = 0; iRowCounter <= NUMBER_OF_ROWS; iRowCounter++)
    {
        drawRow(iRowCounter);
	
    }   
     for(iColCounter = 0; iColCounter <= NUMBER_OF_COLS; iColCounter++)
    {
        drawCol(iColCounter);
		
    }   
    
	drawWhiteTerror();
	drawBlackTerror();
	drawRiver();
}
function drawRow(i)
{
   ctx.lineWidth=1;
   ctx.moveTo(offsetX,offsetY+i * BLOCK_SIZE_H);
   ctx.lineTo(canvas.width-offsetX,offsetY+i * BLOCK_SIZE_H);
   ctx.stroke();
}
function drawCol(i)
{
   ctx.lineWidth=1;
   ctx.moveTo(offsetX+i*BLOCK_SIZE_W,offsetY);
   ctx.lineTo(offsetX+i*BLOCK_SIZE_W,canvas.height-offsetY);
   ctx.stroke();
 
}
function drawRiver()
{
ctx.setFillColor("#fff");
ctx.fillRect(offsetX,offsetY+4*BLOCK_SIZE_H,canvas.width-2*offsetX,1*BLOCK_SIZE_H);

}
function drawWhiteTerror()
{
ctx.moveTo(offsetX+3*BLOCK_SIZE_W,offsetY);
ctx.lineTo(offsetX+5*BLOCK_SIZE_W,offsetY+2*BLOCK_SIZE_H);
ctx.moveTo(offsetX+5*BLOCK_SIZE_W,offsetY);
ctx.lineTo(offsetX+3*BLOCK_SIZE_W,offsetY+2*BLOCK_SIZE_H);
ctx.stroke();
}
function drawBlackTerror()
{
ctx.moveTo(offsetX+3*BLOCK_SIZE_W,offsetY+(NUMBER_OF_ROWS-2)*BLOCK_SIZE_H);
ctx.lineTo(offsetX+5*BLOCK_SIZE_W,offsetY+NUMBER_OF_ROWS*BLOCK_SIZE_H);
ctx.moveTo(offsetX+5*BLOCK_SIZE_W,offsetY+(NUMBER_OF_ROWS-2)*BLOCK_SIZE_H);
ctx.lineTo(offsetX+3*BLOCK_SIZE_W,offsetY+NUMBER_OF_ROWS*BLOCK_SIZE_H);
ctx.stroke();
}
function getPos(c,r)
{
return {x:offsetX+c*BLOCK_SIZE_W,y:offsetY+r*BLOCK_SIZE_H};
}
function getPosR(c,r)
{
return {x:Math.round((c-offsetX)/BLOCK_SIZE_W),y:Math.round((r-offsetY)/BLOCK_SIZE_H)};
}

function placePieces()
{
$(data).each(function(i,v)
{
_x=v.x;
_y=v.y;
piece = {name:pieces[v.p%10],side:sides[Math.round(v.p/20)]};
imgtag='<img data-pid="'+v.p+'" data-side="'+piece.side+'" data-name="'+piece.name+'" class="piece" style="position:absolute;width:50px;height:50px;" src="../images/'+piece.side+"_"+piece.name+".png"+'">")';
imgObj=$(imgtag).appendTo('#board-mark');
imgObj.animate({'left':(offsetX+_x*BLOCK_SIZE_W)-imgObj.width()/2,'top':(offsetY+_y*BLOCK_SIZE_H)-imgObj.height()/2},500);
});
//$('#den_tot').animate({'left':(offsetX+0*BLOCK_SIZE_W)-$('#den_tot').width()/2,'top':(offsetY+3*BLOCK_SIZE_H)-$('#den_tot').height()/2},1000);

}

function moveable_pieces()
{
 //$(".piece").draggable({ grid: [ BLOCK_SIZE_W, BLOCK_SIZE_H ] });
 var gridWidth = BLOCK_SIZE_W;
var gridHeight = BLOCK_SIZE_H;
Draggable.create(".piece", {
    type:"x,y",
    edgeResistance:0.65,
    bounds:"#board",
    throwProps:true,
    snap: {
        x: function(endValue) {
            return Math.round(endValue / gridWidth) * gridWidth;
        },
        y: function(endValue) {
            return Math.round(endValue / gridHeight) * gridHeight;
        }
    }
});

 }

 function board_json()
{
$('.piece').each(function(i,v)
{
x = $(v).offset().left;
y = $(v).offset().top;
console.log({id:$(v).data('pid'),pos:getPosR(x,y)});
});
}
$(document).ready(function(){
render();
moveable_pieces();
});