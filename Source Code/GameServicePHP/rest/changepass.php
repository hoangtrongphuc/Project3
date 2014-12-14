<?php
$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['user_id']) && !empty($array['user_pass'])){
	$userid = $array['user_id'];
	$pass = $array['user_pass'];
	
	$user_model->updatePass($userid, $pass);
	
	$response['code'] = 0;
	$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
	$user_model->deliver_response($response);
}
else{
	$response['code'] = 11;
	$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
	$user_model->deliver_response($response);
}