<?php
$array = $_REQUEST;
$feedback_model = new feedback_model();

if(!empty($array['user_id']) && !empty($array['feedback_title']) && !empty($array['feedback_info']) && !empty($array['feedback_date'])){
	if(preg_match($feedback_model::$regular_expression['number'], $array['user_id'])){
		$id = $array['user_id'];
		$title = $array['feedback_title'];
		$info = $array['feedback_info'];
		$date = date_create($array['feedback_date']);
		$date = date_format($date, 'Y-m-d H:i:s');
	
		$feedback_model->insertFeedBack($id, $title, $info, $date);
		
		$response['code'] = 0;
		$response['status'] = $feedback_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $feedback_model::$api_response_code[ $response['code'] ]['Message'];
		$feedback_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $feedback_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $feedback_model::$api_response_code[ $response['code'] ]['Message'];
		$feedback_model->deliver_response($response);
	}
}
else{
	$response['code'] = 11;
	$response['status'] = $feedback_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $feedback_model::$api_response_code[ $response['code'] ]['Message'];
	$feedback_model->deliver_response($response);
}