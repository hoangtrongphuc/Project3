<?php
$array = array();
$array = $_REQUEST;

$feedback_model = new feedback_model();

if(!empty($array['listfeedback'])){
	if($array['page_number'] == NULL){
		$page_number = 0;
	}else{
		$page_number = $array['page_number'];
	}
	$start = $page_number;
	$limit = 8;
	$total_record = $feedback_model->totalPage('tbl_feedback');
	$total_page = ceil($total_record/$limit);
	if($total_record > $page_number){
	
		$data = array();
		$data = $feedback_model->listFeedBack($start, $limit);
		
		$response['code'] = 0;
		$response['status'] = $feedback_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$response['start'] = $start;
		$response['limit'] = $limit;
		$response['totalpage'] = $total_page;
		$feedback_model->deliver_response($response);
	}
	else{
		$response['code'] = 23;
		$response['status'] = $feedback_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $feedback_model::$api_response_code[ $response['code'] ]['Message'];
		$feedback_model->deliver_response($response);
	}
}
else if(!empty($array['deletefeedback']) && !empty($array['feedback_id'])){
	if(preg_match($feedback_model::$regular_expression['number'], $array['feedback_id'])){
		$id = $array['feedback_id'];
		$feedback_model->deleteFeedBack($id);
		
		$response['code'] = 0;
		$response['status'] = $feedback_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $feedback_model::$api_response_code[ $response['code'] ]['Message'];;
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