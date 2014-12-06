<?php
$array = $_REQUEST;
$event_model = new event_model();
if(!empty($array['listevent'])){
	if($array['page_number'] == NULL){
		$page_number = 0;
	}else{
		$page_number = $array['page_number'];
	}
	$start = $page_number;
	$limit = 1;
	$total_record = $event_model->totalPage('tbl_event');
	$total_page = ceil($total_record/$limit);
	if($total_record > $page_number){
	
		$data = array();
		$data = $event_model->listEvent($start, $limit);
		
		$response['code'] = 0;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$response['start'] = $start;
		$response['limit'] = $limit;
		$response['totalpage'] = $total_page;
		$event_model->deliver_response($response);
	}
	else{
		$response['code'] = 23;
		$response['status'] = $feedback_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $feedback_model::$api_response_code[ $response['code'] ]['Message'];
		$feedback_model->deliver_response($response);
	}
}
else if(!empty($array['homelistevent'])){
	$data = array();
	$data = $event_model->listEventHome(0, 10);
	
	$response['code'] = 0;
	$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$event_model->deliver_response($response);
}
else if(!empty($array['getevent']) && !empty($array['event_id'])){
	if(preg_match($event_model::$regular_expression['number'], $array['event_id'])){
		$id = $array['event_id'];
		$data = array();
		$data = $event_model->getEvent($id);
		
		$response['code'] = 0;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$event_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
		$event_model->deliver_response($response);
	}
}
else if(!empty($array['insertevent']) && !empty($array['title']) && !empty($array['info']) && !empty($array['start']) && !empty($array['finish'])){
	$title = $array['title'];
	$info = $array['info'];
	$start = $array['start'];
	$finish = $array['finish'];
	
	//kiểm tra tiêu đề có tồn tại chưa
	$checktitle = $event_model->checkTitle("",$title);
	if($checktitle == true){
		$response['code'] = 13;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
		$event_model->deliver_response($response);
	}
	else{
	
		$event_model->insert($title, $info, $start, $finish);
		
		$response['code'] = 0;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
		$event_model->deliver_response($response);
	}
}
else if(!empty($array['editevent']) && !empty($array['event_id']) && !empty($array['title']) && !empty($array['info']) && !empty($array['start']) && !empty($array['finish'])){
	if(preg_match($event_model::$regular_expression['number'], $array['event_id'])){
		$id = $array['event_id'];
		$title = $array['title'];
		$info = $array['info'];
		$start = $array['start'];
		$finish = $array['finish'];
		
		//kiểm tra tiêu đề có tồn tại chưa
		$checktitle = $event_model->checkTitle($id, $title);
		if($checktitle == true){
			$response['code'] = 13;
			$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
			$event_model->deliver_response($response);
		}
		else{
		
			$event_model->edit($id, $title, $info, $start, $finish);
			
			$response['code'] = 0;
			$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
			$event_model->deliver_response($response);
		}
	}
	else{
		$response['code'] = 15;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
		$event_model->deliver_response($response);
	}
}
else if(!empty($array['deleteevent']) && !empty($array['event_id'])){
	if(preg_match($event_model::$regular_expression['number'], $array['event_id'])){
		$id = $array['event_id'];
		
		$event_model->delete($id);
		
		$response['code'] = 0;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
		$event_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
		$event_model->deliver_response($response);
	}
}
else if(!empty($array['searchevent']) && !empty($array['event_title'])){
	if(preg_match($event_model::$regular_expression['string'], $array['event_title'])){
		$name = $array['event_title'];
		
		$data = array();
		$data = $event_model->search($name);
		
		$response['code'] = 0;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$event_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
		$event_model->deliver_response($response);
	}
}
else{
	$response['code'] = 11;
	$response['status'] = $event_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $event_model::$api_response_code[ $response['code'] ]['Message'];
	$event_model->deliver_response($response);
}