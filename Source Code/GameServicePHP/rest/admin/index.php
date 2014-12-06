<?php
	header("Content-Type:application/json; charset=utf-8");
	require_once '../library/config.php';
	require_once '../library/database.php';
	require_once 'library/adminmodel.php';
	require_once 'library/user_model.php';
	require_once 'library/thongke_model.php';
	require_once 'library/event_model.php';
	require_once 'library/trade_model.php';
	require_once 'library/feedback_model.php';
	
	$array = array();
	$array = $_REQUEST;
	
	if(!empty($array['api']) && $array['api']=="login"){
		include 'login.php';
	}
	else if(!empty($array['api']) && $array['api']=="user"){
		include 'user.php';
	}
	else if(!empty($array['api']) && $array['api']=="thongke"){
		include 'thongke.php';
	}
	else if(!empty($array['api']) && $array['api']=="event"){
		include 'event.php';
	}
	else if(!empty($array['api']) && $array['api']=="trade"){
		include 'trade.php';
	}
	else if(!empty($array['api']) && $array['api']=="feedback"){
		include 'feedback.php';
	}
	else if(!empty($array['api']) && $array['api']=="logout"){
		include 'logout.php';
	}
	else{
		//lỗi api
		$adminmodel = new adminmodel();
		$response['code'] = 1;
		$response['status'] = $adminmodel::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $adminmodel::$api_response_code[ $response['code'] ]['Message'];
		$adminmodel->deliver_response($response);
	}