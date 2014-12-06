<?php
$array = array();
$array = $_REQUEST;

$trade_model = new trade_model();

if(!empty($array['listtrade'])){
	if($array['page_number'] == NULL){
		$page_number = 0;
	}else{
		$page_number = $array['page_number'];
	}
	$start = $page_number;
	$limit = 1;
	$total_record = $trade_model->totalPage('tbl_trade');
	$total_page = ceil($total_record/$limit);
	if($total_record > $page_number){
		$data = array();
		$data = $trade_model->listTrade($start, $limit);
		
		
		$response['code'] = 0;
		$response['status'] = $trade_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$response['start'] = $start;
		$response['limit'] = $limit;
	 	$response['totalpage'] = $total_page;
		$trade_model->deliver_response($response);
	}
	else{
		$response['code'] = 23;
		$response['status'] = $trade_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $trade_model::$api_response_code[ $response['code'] ]['Message'];
		$trade_model->deliver_response($response);
	}
}
else if(!empty($array['searchtrade']) && !empty($array['user_name'])){
	if(preg_match($trade_model::$regular_expression['username'], $array['user_name'])){
		$name = $array['user_name'];
		$data = array();
		$data = $trade_model->search($name);
		
		$response['code'] = 0;
		$response['status'] = $trade_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$trade_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $trade_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $trade_model::$api_response_code[ $response['code'] ]['Message'];
		$trade_model->deliver_response($response);
	}
}
else{
	$response['code'] = 11;
	$response['status'] = $trade_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $trade_model::$api_response_code[ $response['code'] ]['Message'];
	$trade_model->deliver_response($response);
}
