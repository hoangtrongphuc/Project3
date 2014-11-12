<?php
$array = $_REQUEST;
$register_model = new register_model();

if(!empty($array['user_name']) && !empty($array['user_pass']) && !empty($array['user_email']) && !empty($array['signal'])){

	$user_name = $array['user_name'];
	$user_pass = $array['user_pass'];
	$user_email = $array['user_email'];
	$signal = $array['signal'];
	
	$tokenkey = $_COOKIE['coo_tokenkey'];
	
	$tmp_signal = md5($user_name.$user_pass.$tokenkey);
	
	if($tmp_signal == $signal){
		
		$ktUser = $register_model->kt("user_name", $user_name);
		$ktEmail = $register_model->kt("user_email", $user_email);
		
		if($ktUser == true){
			$register_model->deliver_response(5,"username đã tồn tại",$user_name);
		}else if($ktEmail == true){
			$register_model->deliver_response(7,"email đã tồn tại",$user_name);
		}else{
			$user_level = 2;
			$user_status = 2;
			$register_model->insert($user_name, $user_pass, $user_email, $user_level, $user_status);
			$register_model->deliver_response(0,"thành công",$user_name);
		}
	}
	else{
		$register_model->deliver_response(0,"sai signal",$user_name);
	}
}
else{
	$register_model->deliver_response(10,"lỗi hệ thống",NULL);
}