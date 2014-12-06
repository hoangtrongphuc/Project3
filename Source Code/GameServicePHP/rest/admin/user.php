<?php
$array = array();
$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['listuser'])){
	if($array['page_number'] == NULL){
		$page_number = 0;
	}else{
		$page_number = $array['page_number'];
	}
	$start = $page_number;
	$limit = 2;
	$total_record = $user_model->totalPage('tbl_user');
	$total_page = ceil($total_record/$limit);
	if($total_record >= $page_number){
	
		$data = array();
		$data = $user_model->listUser($start, $limit);
		
		$response['code'] = 0;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$response['start'] = $start;
		$response['limit'] = $limit;
		$response['totalpage'] = $total_page;
		$user_model->deliver_response($response);
	}
	else{
		$response['code'] = 23;
		$response['status'] = $trade_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $trade_model::$api_response_code[ $response['code'] ]['Message'];
		$trade_model->deliver_response($response);
	}
}
else if(!empty($array['homelistuser'])){
	$data = array();
	$data = $user_model->listUserHome(0, 10);
	
	$response['code'] = 0;
	$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$user_model->deliver_response($response);
}
else if(!empty($array['insertuser']) && !empty($array['name']) && !empty($array['pass']) && $array['email']){
	if(preg_match($user_model::$regular_expression['username'], $array['name']) && preg_match($user_model::$regular_expression['pass'], $array['pass'])
			&& preg_match($user_model::$regular_expression['email'], $array['email'])){
		$name = $array['name'];
		$pass = md5($array['pass']);
		$fullname = $array['fullname'];
		$gender = $array['gender'];
		$telephone = $array['telephone'];
		$address = $array['address'];
		$email = $array['email'];
		
		//kiểm tra tồn tại user và email chưa
		$checkUser = $user_model->checkUserEmail('user_name', $name);
		$checkEmail = $user_model->checkUserEmail('user_email', $email);
		
		if($checkUser == true){
			$response['code'] = 5;
			$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
			$user_model->deliver_response($response);
		}
		else if($checkEmail == true){
			$response['code'] = 7;
			$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
			$user_model->deliver_response($response);
		}
		else{
			$level = 2;
			$coin = 1000;
			$status = 0;
			$ban_mo = 2;
			$user_model->insert($name, $pass, $fullname, $gender, $telephone, $address, $email, $level, $coin, $status, $ban_mo);
			
			$response['code'] = 0;
			$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
			$user_model->deliver_response($response);
		}
	}else{
		$response['code'] = 15;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
}
else if(!empty($array['deleteuser']) && !empty($array['user_id'])){
	if(preg_match($user_model::$regular_expression['number'], $array['user_id'])){
		$id = $array['user_id'];
		$user_model->delete($id);
		
		$response['code'] = 0;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
}
else if(!empty($array['mouser']) && !empty($array['user_id'])){
	if(preg_match($user_model::$regular_expression['number'], $array['user_id'])){
		$id = $array['user_id'];
		$user_model->moUser($id);
		
		$response['code'] = 0;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
}
else if(!empty($array['banuser']) && !empty($array['user_id'])){
	if(preg_match($user_model::$regular_expression['number'], $array['user_id'])){
		$id = $array['user_id'];
		$user_model->banUser($id);
		
		$response['code'] = 0;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
}
else if(!empty($array['thuongxu']) && !empty($array['user_id']) && !empty($array['so_xu'])){
	if(preg_match($user_model::$regular_expression['number'], $array['user_id']) && preg_match($user_model::$regular_expression['number'], $array['so_xu'])){
		$id = $array['user_id'];
		$so_xu = $array['so_xu'];
		
		//lấy ra số xu trong tài khoản trước khi thưởng xu
		$getuser = $user_model->getUser($id);
		$tmp_xu = $getuser['user_coin'];
		
		//tính tổng số xu
		$total_xu = $tmp_xu + $so_xu;
		
		$user_model->updateXu($id, $total_xu);
		
		$data = array();
		$data = $user_model->getUser($id);;
		$response['code'] = 0;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$user_model->deliver_response($response);
	}else{
		$response['code'] = 15;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
}
else if(!empty($array['search']) && !empty($array['user_name'])){
	if(preg_match($user_model::$regular_expression['username'], $array['user_name'])){
		$username = $array['user_name'];
		
		$data = array();
		$data = $user_model->search($username);
		
		$response['code'] = 0;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$user_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
		$user_model->deliver_response($response);
	}
}
else{
	$response['code'] = 11;
	$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
	$user_model->deliver_response($response);
}