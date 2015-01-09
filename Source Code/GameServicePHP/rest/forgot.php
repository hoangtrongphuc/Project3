<?php
require_once 'class/sendmail.php';
$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['user_name']) && !empty($array['user_email'])){
	if(preg_match($user_model::$regular_expression['username'], $array['user_name']) && preg_match($user_model::$regular_expression['email'], $array['user_email'])){
		$user_name = $array['user_name'];
		$user_email = $array['user_email'];
		
		$ktEmail = $user_model->ktEmail($user_name, $user_email);
		
		if($ktEmail == true){
			
			$pass = rand(1, 10000000);
			$user_pass = md5($pass);
			$newpass1 = substr($user_pass, 0,7);
			$newpass2 = md5($newpass1);
			$newpass2 = $newpass2[0].$newpass2;
			//thực hiện gửi pass mới vào email
			$sendmail = new sendmail();

			$body = 'Đây là mật khẩu của tài khoản '.$user_name.' của trang web '.urlClient.': '.$newpass1.'. 
					Hãy đổi mật khẩu ngay để đảm bảo tính bảo mật của tài khoản. Xin chân thành cảm ơn!';
			
			$result = $sendmail->smtpmailer($user_email, GUSER, 'Administrator', 'FORGOT PASSWORD', $body);
			if($result == false){
				$response['code'] = 16;
				$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
				$response['data'] = $error;;
				$user_model->deliver_response($response);
			}
			else{
			//cập nhật lại mật khẩu trong database
				$user_model->updatePassForGot($user_name, $newpass2);
				
				$response['code'] = 0;
				$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
				$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
				$user_model->deliver_response($response);
			}
		}
		else{
			$response['code'] = 8;
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