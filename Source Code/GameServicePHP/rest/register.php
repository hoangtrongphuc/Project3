<?php
$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['user_name']) && !empty($array['user_pass']) && !empty($array['user_email']) && !empty($array['signal'])){
	if(preg_match($user_model::$regular_expression['username'], $array['user_name']) && preg_match($user_model::$regular_expression['pass'], $array['user_pass']) 
			&& preg_match($user_model::$regular_expression['email'], $array['user_email']) && preg_match($user_model::$regular_expression['string'], $array['signal'])){
		$user_name = $array['user_name'];
		$user_pass = $array['user_pass'];
		$user_email = $array['user_email'];
		$signal = $array['signal'];
		
		//lấy tokenkey đã đc setcookie
		$tokenkey = $_COOKIE['cookie_tokenkey'];
		
		//tạo mã signal để kiểm tra
		$tmp_signal = md5($user_name.$user_pass.$tokenkey);
		
		//thêm bit muối cho pass
		//$pass = $pass[0].$pass;
		
		if($tmp_signal == $signal){
			
			//kiểm tra username và email đã tồn tại chưa
			$ktUser = $user_model->kt("user_name", $user_name);
			$ktEmail = $user_model->kt("user_email", $user_email);
			
			if($ktUser == true){
				$response['code'] = 5;
				$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
				$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
				$user_model->deliver_response($response);
			}else if($ktEmail == true){
				$response['code'] = 7;
				$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
				$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
				$user_model->deliver_response($response);
			}else{
				$user_level = 2;//tài khoản Member
				$user_ban_mo = 2;//trạng thái tài khoản hoạt động bình thường
				$user_coin = 1000;
				$gender = 2;//chưa xác định
				$user_model->insert($user_name, $user_pass, $gender, $user_email, $user_coin, $user_level, $user_ban_mo);
				
				$response['code'] = 0;
				$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
				$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
				$user_model->deliver_response($response);
			}
		}
		else{
			$response['code'] = 2;
			$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
			$user_model->deliver_response($response);
		}
	}
	else{
		$response['code'] = 15;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
}
else{
	$response['code'] = 11;
	$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
	$user_model->deliver_response($response);
}