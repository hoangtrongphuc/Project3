// JavaScript Document
$(document).ready(function(e) {
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
	register();
	function register(){
		$('#submit-signup').click(function(e) {
			var tokenkey1 = getCookie("cookie_tokenkey");
			alert("dsadsa");
			var name = $('#username1').val();	
			var pass = $('#pass1').val();
			var repass = $('#repass').val();
			var email = $('#email').val();
			email = email.trim().toLowerCase();
			var stremail = /^[a-z]{1}[a-zA-Z0-9.]{2,}@[a-zA-Z0-9-_]{2,10}\.[a-zA-Z]{2,5}$/;
			var strusername = /^[a-zA-Z0-9]\w+[a-zA-Z0-9]$/;
		    if(name == '' || pass == '' || repass == ''){
			   $('#error-all').html("Bạn cần nhập đầy đủ thông tin");
					//return false;
		    }else{
			    	$('#error-all').html(" ");
					//alert('sau eror');
					if(name.length <6 || name.length >32){
						
						alert('Tài khoản phải lớn hơn 6 và nhỏ hơn 32 kí tự');
						return false;
					}
					else if(pass.length <6 || pass.length >32 ){
						//$('#error-user').show();
						alert('mật khẩu quá ngắn hoặc quá dài');
						return false;
					}
					else if(pass != repass){
						//$('#error-user').show();
						alert('lỗi mật khẩu không khớp');
						return false;
					}
					else if(stremail.test(email) == false){
						//$('#error-user').show();
						alert('lỗi email không hợp lệ');
						return false;
					}
					else if(strusername.test(name) == false){
						alert('lỗi tài khoản không hợp lệ');
						return false;
					}
					
					pass = CryptoJS.MD5(pass);
					// muối thêm bit muối vào pass
					pass= String(pass);
					var newpass = pass.charAt(0)+pass;
					var str = name+newpass+tokenkey1;
					var signal = CryptoJS.MD5(str);
					
					$.ajax({
						url	: "http://localhost:8080/rest/index.php?api=register", // Nơi nhận dữ liệu
						type  : "post", // Phương thức truyền dữ liệu
						data  : "user_name="+name+"&user_pass="+newpass+"&user_email="+email+"&signal="+signal, // Dữ liệu cần truyền sang PHP
						async : false,
						success : function(result){ // Nhận kết quả trả về từ PHP				
							if(result.code == 0){
								alert("Đăng ký thành công");
							}
							else{
								alert(result.data);
							}
						},
						error : function(err){
							alert(JSON.stringify(err));
						}
					});
					
			   }
			});
	}
});