// JavaScript Document
$(document).ready(function(e) {
	
	$('#submit-signup').click(function(e) {
	//alert("dsadsa");
	name = $('#username1').val();	
	pass = $('#pass1').val();
	repass = $('#repass').val();
		//alert("name");
   if(name == '' || pass == '' || repass == ''){
	   $('#error-all').html("Bạn cần nhập đầy đủ thông tin");
			//return false;
   }else{
	    $('#error-all').html(" ");
			//alert('sau eror');
			if(name.length <6 || name.length >32){
				
				alert('loi tai khoan');
			}
			else if(pass.length <6 || pass.length >32 ){
				$('#error-user').show();
				alert('mat khau quan ngan hoacj qua dai');
			}
			else if(pass != repass){
				$('#error-user').show();
				alert('loi mat khau khong khop');
			}
			
		/*$.ajax({
				"url"	: "<?php echo 'untitled/process-signup.php';?>", // Nơi nhận dữ liệu
				"type"  : "post", // Phương thức truyền dữ liệu
				"data"  : "&name="+name+"&pass="+pass+"&repass="+repass, // Dữ liệu cần truyền sang PHP
				"async" : false,
				success : function(result){ // Nhận kết quả trả về từ PHP				
					alert(result);
					if(result == 1){
						$('#error-pass').html(".");					
						return false;
					}else if(result == 2){
						$('#error-repass').html(".");
						return false;
					}
					
					else{
						
						
					}
				}
		});
	   */}
});
	$('input[name=user]').keyup(function(e) {
		//alert('dasdsa');
        name = $('#username1').val();
		//alert(name.length);
		if( name.length > 5 && name.length < 32){
				$('#error-user').show();
				//alert('loi tai khoan');
			}else{
				$('#error-user').hide();
			}
		
    });
	
	$('input[name=pass]').keyup(function(e) {
		//alert('dasdsa');
        pass = $('#pass1').val();
		//alert(name.length);
		if( pass.length > 5 && pass.length < 32){
				$('#error-pass').show();
				//alert('loi tai khoan');
			}else{
				$('#error-pass').hide();
			}
		
    });
	
	$('input[name=repass]').keyup(function(e) {
		//alert('dasdsa');
        pass = $('#pass1').val();
		repass = $('#repass').val();
		//alert(name.length);
		if( pass == repass){
				$('#error-repass').show();
				//alert('loi tai khoan');
			}else{
				$('#error-repass').hide();
			}
		
    });
	
	 $('#submit-signup').click(function(e) {
		//alert('đasa');
        name = $('#username1').val();
	//	pass = window.md5($('#pass').val());
		pass = $('#pass1').val();
		repass = $('#repass').val();
		//alert(pass);
		$.ajax({
				"url"	: "http://192.168.1.51:8080/rest/index.php?api=register", // Nơi nhận dữ liệu
				"type"  : "post", // Phương thức truyền dữ liệu
				"data"  : "&user_name="+name+"&user_pass="+pass+"&user_email="+repass, // Dữ liệu cần truyền sang PHP
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