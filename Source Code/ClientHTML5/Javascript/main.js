// JavaScript Document
function bigger()
{
setTimeout(function zxc()
{
$('#submit-login').css({
'transform':'scale(1.15)',
'font-size':'20px'
});
smaller();
},200);
};	

function smaller(){
	setTimeout(function zxc()
{
$('#submit-login').css({
'transform':'scale(1.05)',
'font-size':'20px'
});
bigger();
},300);
};

bigger();
$(document).ready(function(e) {
	$('#submit-signin').hover(function(e){

		
		
	});

    $('#submit-login').click(function(e) {
		//alert('đasa');
        name = $('#username').val();
	//	pass = window.md5($('#pass').val());
		pass = $('#pass').val();
		//alert(pass);
		$.ajax({
				"url"	: "http://localhost:8080/rest/index.php?api=login", // Nơi nhận dữ liệu
				"type"  : "post", // Phương thức truyền dữ liệu
				"data"  : "&username="+name+"&pass="+pass, // Dữ liệu cần truyền sang PHP
				"async" : false,
				success : function(result){ // Nhận kết quả trả về từ PHP				
					alert(result);
					if(result == 1){
						alert('1');
						//$('#error-pass').html(".");					
						return false;
					}else if(result == 2){
						alert('2');
						//$('#error-repass').html(".");
						return false;
					}
					
					else{
						
						
					}
				}
		});
		
    });
	$('#submit-login').animate({left:20},50);
});