<?php
$array = array();
$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['user_id'])){
	if(preg_match($user_model::$regular_expression['number'], $array['user_id'])){
		$id = $array['user_id'];
		
		if(isset($_COOKIE['cookie_id']))
			setcookie("cookie_id",$_COOKIE['cookie_id'],time() - 24*3600,'/');
		if(isset($_COOKIE['cookie_username']))
			setcookie("cookie_username",$_COOKIE['cookie_username'],time() - 24*3600, '/');
		if(isset($_COOKIE['cookie_level']))
			setcookie("cookie_level",$_COOKIE['cookie_level'],time() - 24*3600, '/');
		if(isset($_COOKIE['cookie_tokenkey']))
			setcookie("cookie_tokenkey",$_COOKIE['cookie_tokenkey'],time() - 24*3600, '/');
		
		$user_model->updateStatusID($id, '0');
		
		$response['code'] = 0;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $model::$api_response_code[ $response['code'] ]['Message'];
		$model->deliver_response($response);
	}
}
else{
	$response['code'] = 11;
	$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
	$user_model->deliver_response($response);
}