// JavaScript Document

$(document).ready(function() {
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
	//lấy gói tokenkey
	
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
    login();
    function login(){
    	$('#submit-login').click(function() {
    		var tokenkey = getCookie("cookie_tokenkey");
            var $name = $('#username').val();
    		//pass = window.md5($('#pass').val());
    		var $pass = $('#pass').val();
    		if($name == "" || $pass == ""){
    			alert("bạn chưa nhập dữ liệu!!!");
    		}
    		else{
    			var $pass = CryptoJS.MD5($pass);
    			//thêm bit muối
    			$pass = String($pass);
    			$pass = $pass.charAt(0)+$pass;
    			var str = $name+$pass+tokenkey;
    			
    			var $signal = CryptoJS.MD5(str);
    			$.ajax({
    				url	: "http://localhost:8080/rest/index.php?api=login", // Nơi nhận dữ liệu
    				type  : "post", // Phương thức truyền dữ liệu
    				dataType : "json",
    				data  : "username="+$name+"&pass="+$pass+"&signal="+$signal, // Dữ liệu cần truyền sang PHP
    				async:false,
    				success : function(result){ // Nhận kết quả trả về từ PHP	
    					//alert(JSON.stringify(result));
    					if(result.code == 0){
    						var tokenkey = result.data.tokenkey;
							 window.location.href = "http://localhost:8080/cotuong/banco";
    					}
    					else{
    						alert(result.data);
    					}
    				},
    				error: function(error){
    					alert(JSON.stringify(error));
    			    }
    			});
    		}
        });
    }
    
});