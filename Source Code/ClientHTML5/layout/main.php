<script type="text/javascript">

$(document).ready(function(){
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
			var getcookie_id = getCookie("cookie_id");
			if(getcookie_id !== ""){
					window.location.href = "http://localhost:8080/cotuong/banco";
					return false;
				}

			else
				tokenkey();
	function tokenkey(){
		$.ajax({
			url	: "http://localhost:8080/rest/index.php?api=tokenkey", // Nơi nhận dữ liệu
			type  : "post", // Phương thức truyền dữ liệu
			dataType : "json",
			data  : null,
			async:false,
			success : function(result){ 
				
			},
			error: function(error){
				alert(JSON.stringify(error));
		    }
		});
	}
});
</script>
<script type="text/javascript" src='Javascript/main.js'></script>
<script type="text/javascript" src='Javascript/sighup.js'></script>
<div id="wrapper" >
  <div id="wp-row2">

    <div id="login">
      <form class="form-signin" role="form" action="javascript:void(0)" method="post">
        <h3 style="font-family:'Comic Sans MS', cursive;">Đăng Nhập</h3>
        <table width="150" border="0" cellspacing="20" style="margin-left:40px;">
          <tr>
            <td><div class="form-group has-success has-feedback">
                <label class="control-label" for="username">Tên tài khoản</label>
                <input type="text" class="form-control" id="username" placeholder="Nhập tài khoản của bạn" name="username"  required >
              </div></td>
          </tr>
          <tr>
            <td><div class="form-group has-success has-feedback">
                <label class="control-label" for="username">Mật khẩu</label>
                <input type="password" class="form-control" id="pass" placeholder="Nhập mật khẩu" name="pass"  required>
              </div></td>
          </tr>
          <tr>
            <td></td>
          </tr>
          <tr>
          

            <td><button id="submit-login" style="margin-right:30px;  margin-top:20px;" class="btn btn-lg btn-danger btn-block" type="submit">Chơi Ngay</button>
            <a href="offline/index.html"><button class="btn btn-lg btn-default btn-block" style="margin-top:10px;" type="button"	 >Chơi với máy</button></a></td>
          </tr>
          <tr>
            <td>
            <a href="#" style="font-family:'Comic Sans MS', cursive; padding:0 0px 0 50px;" >Quên mật khẩu??</a></td>
          </tr>
        </table>
      </form>
    </div>
    <div id="or">         </div>
    
    <div id="signin" >
      <form class="form-inline" role="form" action="javascript:void(0)" method="post">
      <h3 style="font-family:'Comic Sans MS', cursive;">Đăng Kí Nhanh</h3>
      <table width="350" border="0" cellspacing="20" style="margin-left:20px;">
      <tr>
        <td>
      
        <div class="form-group has-success has-feedback">
          <label class="control-label col-sm-5" for="username">Tài khoản</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="username1" name="user">
            <span id="error-user" class="glyphicon glyphicon-ok form-control-feedback" style="margin-right:5px; display:none;"></span> </div>
        </div>
     
      </td>
      </tr>
      <tr>
        <td>
            <div class="form-group has-success has-feedback">
              <label class="control-label col-sm-4" for="pass">Mật khẩu</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="pass1" name="pass">
                <span id="error-pass" class="glyphicon glyphicon-ok form-control-feedback" style="margin-right:5px; display:none;"  ></span> </div>
            </div>
            
            
            
          </td>
      </tr>
      <tr>
        <td>
            <div class="form-group has-success has-feedback">
              <label class="control-label col-sm-6" for="repass">Nhập lại mật khẩu</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="repass" name="repass">
                <span id="error-repass" class="glyphicon glyphicon-ok form-control-feedback" style="margin-right:5px; display:none;"></span> 
                </div>
            </div>
          </td>
      </tr>
      
      <tr>
        <td>
            <div class="form-group has-success has-feedback">
              <label class="control-label col-sm-6" for="email">Email</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name="email">
                <span id="error-email" class="glyphicon glyphicon-ok form-control-feedback" style="margin-right:5px; display:none;"></span> 
                </div>
            </div>
          </td>
      </tr>
      
      <tr>
        <td><div id="error-all" style="padding-left:20px;"></div></td>
      </tr>
      <tr>
        <td><button id="submit-signup" style="margin:0 30px; width:240px;" class="btn btn-lg btn-success btn-block" type="submit">Đăng kí ngay</button></td>
      </tr>
      
      </table>
      </form>
    </div>
  </div>
</div>