<?php
$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['username']) && !empty($array['email'])){
	if(preg_match($user_model::$regular_expression['username'], $array['username']) && preg_match($user_model::$regular_expression['number'], $array['gender']) && preg_match($user_model::$regular_expression['email'], $array['email'])){
		$username = $array['username'];
		$fullname = $array['fullname'];
		$gender = $array['gender'];
		$phone = $array['phone'];
		$address = $array['address'];
		$email = $array['email'];
		
		//kiểm tra 
		$checkemail = $user_model->ktEmailChangeInfo($username, $email);
		if($checkemail == true){
			$response['code'] = 7;
			$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
			$user_model->deliver_response($response);
		}
		else{
			$user_model->updateInfo($username, $fullname, $gender, $phone, $address, $email);
			
			$response['code'] = 0;
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