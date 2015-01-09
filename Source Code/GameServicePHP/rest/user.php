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
else if(!empty($array['updatematch']) && !empty($array['userwin']) && !empty($array['userlose']) && !empty($array['coin'])){
	if(preg_match($user_model::$regular_expression['username'], $array['userwin']) && preg_match($user_model::$regular_expression['username'], $array['userlose']) 
		&& preg_match($user_model::$regular_expression['number'], $array['coin'])){
		
		$userwin = $array['userwin'];
		$userlose = $array['userlose'];
		$coin = $array['coin'];
	
		//tính toán cho người thắng
		$getuserwin = $user_model->getUserName($userwin);
		
		$total_win1 = $getuserwin['user_win'] + 1;
		$total_coin1 = $coin + $getuserwin['user_coin'];
		
		//tính toán cho người thua
		$getuserlose = $user_model->getUserName($userlose);
		
		$total_lose2 = $getuserlose['user_lose'] + 1;
		$total_coin2 = $getuserlose['user_coin'] - $coin;
		//update
		$user_model->updateMatch($userwin, $total_win1," ", $total_coin1);
		$user_model->updateMatch($userlose," ", $total_lose2, $total_coin2);
		
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