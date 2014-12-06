<?php
$array = array();
$array = $_REQUEST;
$user_model = new user_model();
if(!empty($array['user_id'])){
	if(preg_match($user_model::$regular_expression['number'], $array['user_id'])){
		if(isset($_COOKIE['cookie_id']))
			setcookie("cookie_id",$_COOKIE['cookie_id'],time() - 3600*24,'/');
		if(isset($_COOKIE['cookie_username']))
			setcookie("cookie_username",$_COOKIE['cookie_username'],time() - 3600*24, '/');
		if(isset($_COOKIE['cookie_level']))
			setcookie("cookie_level",$_COOKIE['cookie_level'],time() - 3600*24, '/');
		
		$id = $array['user_id'];
		
		$user_model->updateStatusID($id, '0');
		
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