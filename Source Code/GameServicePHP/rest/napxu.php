<?php
$array = $_REQUEST;
$napxu_model = new napxu_model();

if(!empty($array['xu']) && !empty($array['user_id']) && !empty($array['provider']) && !empty($array['code']) && !empty($array['serial']) && !empty($array['date'])){
	if(preg_match($napxu_model::$regular_expression['number'], $array['user_id']) && preg_match($napxu_model::$regular_expression['string'], $array['provider']) 
			&& preg_match($napxu_model::$regular_expression['string'], $array['code']) && preg_match($napxu_model::$regular_expression['string'], $array['serial'])){
		$id = $array['user_id'];
		$provider = strtolower($array['provider']);
		$code = $array['code'];
		$serial = $array['serial'];
		$date = date_create($array['date']);
		$date = date_format($date, 'Y-m-d H:i:s');
		
		$ktMaThe = $napxu_model->ktMaThe($provider, $code, $serial);
		
		if($ktMaThe == true){
			
			$getUser = $napxu_model->getUser('user_ID', $id);
			$getXu = $napxu_model->getXu($serial);
			
			//lưu lại lịch sử giao dịch vào bảng trade
			$napxu_model->insertTrade($id, $provider, $serial, $code, $getXu['card_coin'] , $date);
			
			//tính tổng số xu
			$total_coin = $getUser['user_coin'] + $getXu['card_coin'];
			
			//cập nhật lại xu trong bảng user
			$napxu_model->updateXu($id, $total_coin);
			
			//update status=1 trong bảng examplecard 
			//thẻ chỉ được nạp 1 lần
			$napxu_model->updateCardStatus($getXu['card_ID'], '1');
			
			$response['code'] = 0;
			$response['status'] = $napxu_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $napxu_model::$api_response_code[ $response['code'] ]['Message'];
			$napxu_model->deliver_response($response);
		}
		else{
			$response['code'] = 9;
			$response['status'] = $napxu_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $napxu_model::$api_response_code[ $response['code'] ]['Message'];
			$napxu_model->deliver_response($response);
		}
	}
	else{
		$response['code'] = 15;
		$response['status'] = $napxu_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $napxu_model::$api_response_code[ $response['code'] ]['Message'];
		$napxu_model->deliver_response($response);
	}
}
else if(!empty($array['checkxu']) && !empty($array['user_id']) && !empty($array['coin'])){
	if(preg_match($napxu_model::$regular_expression['number'], $array['user_id']) && preg_match($napxu_model::$regular_expression['number'], $array['coin'])){
		$id = $array['user_id'];
		$coin = $array['coin'];
		
		$checkxu = $napxu_model->checkXu($id, $coin);
		if($checkxu == true){
			$response['code'] = 0;
			$response['status'] = $napxu_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $napxu_model::$api_response_code[ $response['code'] ]['Message'];
			$napxu_model->deliver_response($response);
		}
		else{
			$response['code'] = 14;
			$response['status'] = $napxu_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $napxu_model::$api_response_code[ $response['code'] ]['Message'];
			$napxu_model->deliver_response($response);
		}
	}
	else{
		$response['code'] = 15;
		$response['status'] = $napxu_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $napxu_model::$api_response_code[ $response['code'] ]['Message'];
		$napxu_model->deliver_response($response);
	}
}
else{
	$response['code'] = 11;
	$response['status'] = $napxu_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $napxu_model::$api_response_code[ $response['code'] ]['Message'];
	$napxu_model->deliver_response($response);
}