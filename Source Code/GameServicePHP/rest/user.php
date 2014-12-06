<?php
$array = array();
$array =$_REQUEST;
$user_model = new user_model();
if(!empty($array['getuser']) && !empty($array['username'])){
	if(preg_match($user_model::$regular_expression['username'], $array['username'])){
		$username = $array['username'];
		
		$data = array();
		$data = $user_model->getUserName($username);
		
		$response['code'] = 0;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$user_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
}
else if(!empty($array['updatematch']) && !empty($array['user_name']) && !empty($array['win']) && !empty($array['lose']) && !empty($array['coin'])){
	if(preg_match($user_model::$regular_expression['username'], $array['user_name']) && preg_match($user_model::$regular_expression['number'], $array['win']) 
		&& preg_match($user_model::$regular_expression['number'], $array['lose']) && preg_match($user_model::$regular_expression['number'], $array['coin'])){
		$user_name = $array['user_name'];
		$win = $array['win'];
		$lose = $array['lose'];
		$coin = $array['coin'];
		
		$getuser = $user_model->getUserName($user_name);
	
		//tính toán
		$total_win = $win + $getuser['user_win'];
		$total_lose = $lose + $getuser['user_lose'];
		$total_coin = $coin + $getuser['user_coin'];
		//update
		$user_model->updateMatch($user_name, $total_win, $total_lose, $total_coin);
		
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
else if(!empty($array['updateuser']) && !empty($array['user_id']) && !empty($array['user_name']) && !empty($array['email'])){
	if(preg_match($user_model::$regular_expression['number'], $array['user_id']) && preg_match($user_model::$regular_expression['username'], $array['user_name']) && preg_match($user_model::$regular_expression['email'], $array['email'])){
		$id = $array['user_id'];
		$username = $array['user_name'];
		$fullname = $array['fullname'];
		$gender = $array['gender'];
		$telephone = $array['telephone'];
		$address = $array['address'];
		$email = $array['email'];
		
		$user_model->updateUser($id, $username, $fullname, $gender, $telephone, $address, $email);
		
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