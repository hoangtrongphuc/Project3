<?php
$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['user_id']) && !empty($array['email'])){
	if(preg_match($user_model::$regular_expression['number'], $array['user_id']) && preg_match($user_model::$regular_expression['number'], $array['gender']) && preg_match($user_model::$regular_expression['email'], $array['email'])){
		$userid = $array['user_id'];
		$pass = $array['pass'];
		$fullname = $array['fullname'];
		$gender = $array['gender'];
		$phone = $array['phone'];
		$address = $array['address'];
		$email = $array['email'];
		
		if($array['pass'] != ""){
			//thêm bit muối cho pass
			$pass = $pass[0].$pass;
		}
		$user_model->updatePass($userid, $pass, $fullname, $gender, $phone, $address, $email);
		
		$response['code'] = 0;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
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