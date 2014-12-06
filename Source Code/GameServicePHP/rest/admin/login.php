<?php
session_start();

$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['username']) && !empty($array['pass'])){
	if(preg_match($user_model::$regular_expression['username'], $array['username']) && preg_match($user_model::$regular_expression['pass'], $array['pass'])){
		$username = $array['username'];
		$pass = $array['pass'];
		
		$check = $user_model->checklogin($username, $pass);
		
		if($check == false){
			$response['code'] = 3;
			$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
			$user_model->deliver_response($response);
		}
		else{
			$_COOKIE['cookie_id'] = $check['user_ID'];
			$_COOKIE['cookie_username'] = $check['user_name'];
			$_COOKIE['cookie_level'] = $check['user_level'];
			setcookie("cookie_id",$_COOKIE['cookie_id'],time() + 3600*24,'/');
			setcookie("cookie_username",$_COOKIE['cookie_username'],time() + 3600*24, '/');
			setcookie("cookie_level",$_COOKIE['cookie_level'],time() + 3600*24, '/');
			
			$user_model->updateStatus($username, '1');
			
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