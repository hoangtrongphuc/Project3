<?php
$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['username']) && !empty($array['email'])){
	if(preg_match($user_model::$regular_expression['username'], $array['username']) && preg_match($user_model::$regular_expression['number'], $array['gender']) && preg_match($user_model::$regular_expression['email'], $array['email'])){
		$username = $array['username'];
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
		$user_model->updateInfo($username, $pass, $fullname, $gender, $phone, $address, $email);
		
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