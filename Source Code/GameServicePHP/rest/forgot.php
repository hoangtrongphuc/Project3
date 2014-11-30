<?php
$array = $_REQUEST;
$forgot_model = new forgot_model();

if(!empty($array['user_name']) && !empty($array['user_email'])){
	$user_name = $array['user_name'];
	$user_email = $array['user_email'];
	
	$ktEmail = $forgot_model->ktEmail($user_name, $user_email);
	
	if($ktEmail == true){
		$forgot_model->deliver_response(0, "lấy lại mật khẩu thành công", $user_name);
		$pass = rand(100, 10000000);
		$user_pass = md5($pass);
		
		//thực hiện gửi pass mới vào email
		
		
		
		//cập nhật lại mật khẩu trong database
		$forgot_model->updatePass($user_name, $user_pass);
	}
	else{
		$forgot_model->deliver_response(8, "email không tồn tại hoặc không đúng ứng với tài khoản của bạn", $user_name);
	}
}
else{
	$forgot_model->deliver_response(10, "lỗi hệ thống", NULL);
}