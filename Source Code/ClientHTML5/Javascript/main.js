// JavaScript Document

$(document).ready(function(e) {
    $('#submit-login').click(function(e) {
		//alert('đasa');
        name = $('#username').val();
	//	pass = window.md5($('#pass').val());
		pass = $('#pass').val();
		//alert(pass);
		$.ajax({
				"url"	: "http://192.168.1.51:8080/rest/index.php?api=login", // Nơi nhận dữ liệu
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
});