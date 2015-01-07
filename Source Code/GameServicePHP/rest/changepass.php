<?php
$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['user_id']) && !empty($array['pass_old']) && !empty($array['pass_new'])){
	if(preg_match($user_model::$regular_expression['pass'],$array['pass_old']) && preg_match($user_model::$regular_expression['pass'],$array['pass_old'])){
		$userid = $array['user_id'];
		$passold = $array['pass_old'];
		$passnew = $array['pass_new'];
		
		//kiểm tra mật khẩu cũ
		$ktpass = $user_model->ktPass($userid, $passold);
		if($ktpass == true){
			$user_model->updatePass($userid, $passnew);
			
			$response['code'] = 0;
			$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
			$user_model->deliver_response($response);
		}
		else{
			$response['code'] = 3;
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