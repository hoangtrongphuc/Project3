
<script type="text/javascript" src="../config.js"></script>
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
						window.location.href = "http://"+host+"/cotuong/banco";
						return false;
					}
	
				else
					tokenkey();
		function tokenkey(){
			$.ajax({
				url	: "http://"+host+"/rest/index.php?api=tokenkey", // Nơi nhận dữ liệu
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

<div id="wrapper">
<div id="banner-top">
	<div id="logo-banner">
    	<a href="">	
        	<img src="images/logo-banner.png" width="300" height="240" alt="Cờ tướng online" />
        </a>
    </div>
	<div id="notice">
    	<marquee direction="left" contenteditable="false" scrollamount="3" onmouseover="this.stop()" onmouseout="this.start()" title="Game cờ tướng online" dropzone="link"  >Game cờ tướng Online - Game cờ tướng hấp dẫn nhất !!!</marquee>
    </div>

</div>
  <div class="left">
    <div id="login-form">
      <form class="form-signin" role="form" action="javascript:void(0)" method="post">
        <h3>Tài khoản</h3>
        <table width="150" border="0" cellspacing="20">
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
            <td><button id="submit-login" class="btn btn-lg btn-success btn-block" type="submit">Chơi Ngay</button></td>
          </tr>
          <tr>
            <td style="text-align:center; margin:20px auto;"><a href="#forgetpass" class="various" >Quên mật khẩu??</a></td>
          </tr>
          <tr>
            <td><a class="various" href="#signin">
              <button class="btn btn-lg btn-danger btn-block" style="width:80%; margin:10px auto; height:40px;" type="button"> Đăng Kí </button>
              </a></td>
          </tr>
        </table>
      </form>
    </div>
    <div id="open-id">
      
      <table width="250" border="0" cellspacing="20">
        <tr>
          <td><a href="offline/index.html">
            <button class="btn btn-lg btn-warning btn-block" style="width:80%; margin:0 auto;" type="button">Chơi với máy</button>
            </a></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="right">
    <div id="banner-right">
      <h3>Game cờ tướng -  Những quân cờ huyền bí</h3>
      <br />
      <img src="images/banner-right.jpg" alt="lợi ích của việc chơi cờ" width="500" height="350" style="margin-left:125px;"  /> <br />
      &nbsp;&nbsp;&nbsp;Cờ tướng là một môn thể thao trí tuệ.<br />
      &nbsp;&nbsp;&nbsp; Cờ tướng là một môn thể thao trí tuệ được rất nhiều người trên toàn thế giới yêu thích. Chính vì vậy, trò<br /> 	chơi này
      đang rất được yêu thích trên Internet và thu hút được số lượng game thủ lớn trên cộng đồng mạng.<br />
      <br />
      32 quân cờ và hai đối thủ đối mặt với nhau trên một bàn cờ. Mỗi người đều phải tự tính toán để có được nước cờ thông minh <br />
nhất và chiến thắng hiểm hách nhất.<br />


&nbsp;&nbsp;&nbsp; Bạn có thể đăng nhập vào game bằng bất kỳ tài khoản nào.<br />

&nbsp;Nếu chưa có tài khoản, hãy nhanh tay đăng kí để trải nghiệm<br />

    </div>
  </div>
</div>
<div id="signin" style="display:none;" >
  <form class="form-inline" role="form" action="javascript:void(0)" method="post">
    <h3 style="font-family:'Comic Sans MS', cursive;">Đăng Kí Nhanh</h3>
    <table width="350" border="0" cellspacing="20" style="margin-left:50px;">
      <tr>
        <td><div class="form-group has-success has-feedback">
            <label class="control-label col-sm-5" for="username">Tài khoản</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="username1" name="user">
              <span id="error-user" class="glyphicon glyphicon-ok form-control-feedback" style="margin-right:5px; display:none;"></span> </div>
          </div></td>
      </tr>
      <tr>
        <td><div class="form-group has-success has-feedback">
            <label class="control-label col-sm-4" for="pass">Mật khẩu</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="pass1" name="pass">
              <span id="error-pass" class="glyphicon glyphicon-ok form-control-feedback" style="margin-right:5px; display:none;"  ></span> </div>
          </div></td>
      </tr>
      <tr>
        <td><div class="form-group has-success has-feedback">
            <label class="control-label col-sm-6" for="repass">Nhập lại mật khẩu</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="repass" name="repass">
              <span id="error-repass" class="glyphicon glyphicon-ok form-control-feedback" style="margin-right:5px; display:none;"></span> </div>
          </div></td>
      </tr>
      <tr>
        <td><div class="form-group has-success has-feedback">
            <label class="control-label col-sm-6" for="email">Email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" id="email" name="email">
              <span id="error-email" class="glyphicon glyphicon-ok form-control-feedback" style="margin-right:5px; display:none;"></span> </div>
          </div></td>
      </tr>
      <tr>
        <td><div id="error-all" style="padding-left:20px;"></div></td>
      </tr>
      <tr>
        <td><button id="submit-signup" style="margin:30px 30px 0 30px; width:240px;" class="btn btn-lg btn-success btn-block" type="submit">Đăng kí ngay</button></td>
      </tr>
    </table>
  </form>
</div>
<div id="forgetpass" style="display:none;">
		
        <form class="form-forgetpass" role="form" action="javascript:void(0)" method="post">
        <h3>Quên mật khẩu</h3>
        <table width="150" border="0" cellspacing="20">
          <tr>
            <td><div class="form-group has-success has-feedback">
                <label class="control-label" for="username">Tên tài khoản</label>
                <input type="text" class="form-control" id="fuser" placeholder="Nhập tài khoản của bạn" name="fuser" required >
              </div></td>
          </tr>
          <tr>
            <td><div class="form-group has-success has-feedback">
                <label class="control-label" for="femail">Email</label>
                <input type="text" class="form-control" id="femail" placeholder="Nhập Email đăng kí" name="femail"  required>
              </div></td>
          </tr>
          <tr>
            <td></td>
          </tr>
          <tr>
            <td><button id="submit-forgetpass" class="btn btn-lg btn-success btn-block" type="submit">Gửi yêu cầu</button></td>
          </tr>
       
        </table>
      </form>

</div>
