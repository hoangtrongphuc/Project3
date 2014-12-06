<?php
$array = $_REQUEST;
$thongke_model = new thongke_model();

if(!empty($array['useronline'])){
	$data = array();
	$data = $thongke_model->countUserOnline();
	
	$response['code'] = 0;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$thongke_model->deliver_response($response);
}
else if(!empty($array['alluser'])){
	$data = array();
	$data = $thongke_model->countUser();

	$response['code'] = 0;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$thongke_model->deliver_response($response);
}
else if(!empty($array['userban'])){
	$data = array();
	$data = $thongke_model->countUserBan();
	
	$response['code'] = 0;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$thongke_model->deliver_response($response);
}
else if(!empty($array['ccugame'])){
	$data = array();
	$data = $thongke_model->countUserTime();
	
	$response['code'] = 0;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $thongke_model::$api_response_code[ $response['code'] ]['Message'];
	$thongke_model->deliver_response($response);
}
else if(!empty($array['doanhthuthang'])){
	$data = array();
	$data = $thongke_model->incomeMonth();
	
	$response['code'] = 0;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$thongke_model->deliver_response($response);
}
else if(!empty($array['doanhthunam'])){
	$data = array();
	$data = $thongke_model->incomeYear();
	
	$response['code'] = 0;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$thongke_model->deliver_response($response);
}
else if(!empty($array['usernapxumax'])){
	$data = array();
	$data = $thongke_model->userNapXuMax();

	$response['code'] = 0;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$thongke_model->deliver_response($response);
}
else if(!empty($array['thongkefeedback'])){
	$data = array();
	$data = $thongke_model->countFeedBack();
	
	$response['code'] = 0;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$thongke_model->deliver_response($response);
}
else if(!empty($array['thongkeevent'])){
	$data = array();
	$data = $thongke_model->countEvent();

	$response['code'] = 0;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$thongke_model->deliver_response($response);
}
else{
	$response['code'] = 11;
	$response['status'] = $thongke_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $thongke_model::$api_response_code[ $response['code'] ]['Message'];
	$thongke_model->deliver_response($response);
}