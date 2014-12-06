<?php
	header("Content-Type:application/json; charset=utf-8");
	require_once 'library/config.php';
	require_once 'library/database.php';
	require_once 'library/model.php';
	require_once 'library/user_model.php';
	require_once 'library/napxu_model.php';
	require_once 'library/friend_model.php';
	require_once 'library/feedback_model.php';
	require_once 'library/event_model.php';
	
	$array = $_REQUEST;
	
	//$array1 = file_get_contents("php://input");
	//$array = json_decode($array1,true);
	
	if(!empty($array['api']) && $array['api'] == "tokenkey"){
		include 'tokenkey.php';
	}
	else if(!empty($array['api']) && $array['api'] == "login"){
		include 'login.php';
	}
	else if(!empty($array['api']) && $array['api'] == "register"){
		include 'register.php';
	}
	else if(!empty($array['api']) && $array['api'] == "toprank"){
		include 'toprank.php';
	}
	else if(!empty($array['api']) && $array['api'] == "toprick"){
		include 'toprick.php';
	}
	else if(!empty($array['api']) && $array['api'] == "friend"){
		include 'friend.php';
	}
	else if(!empty($array['api']) && $array['api'] == "forgot"){
		include 'forgot.php';
	}
	else if(!empty($array['api']) && $array['api'] == "changeinfo"){
		include 'changeinfo.php';
	}
	else if(!empty($array['api']) && $array['api'] == "napxu"){
		include 'napxu.php';
	}
	else if(!empty($array['api']) && $array['api'] == "user"){
		include 'user.php';
	}
	else if(!empty($array['api']) && $array['api'] == "event"){
		include 'event.php';
	}
	else if(!empty($array['api']) && $array['api'] == "feedback"){
		include 'feedback.php';
	}
	else if(!empty($array['api']) && $array['api'] == "logout"){
		include 'logout.php';
	}
	else{
		$model = new model();
		$response['code'] = 1;
		$response['status'] = $model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $model::$api_response_code[ $response['code'] ]['Message'];
		$model->deliver_response($response);
	}
	
?>