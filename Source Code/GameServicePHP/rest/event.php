<?php
$array = array();
$array = $_REQUEST;
$event_model = new event_model();

if(!empty($array['listevent'])){
	
	$data = array();
	$data = $event_model->listEvent();
	
	$response['code'] = 0;
	$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$event_model->deliver_response($response);
}
else{
	$response['code'] = 11;
	$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
	$event_model->deliver_response($response);
}