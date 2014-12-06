<?php
$array = $_REQUEST;
$friend_model = new friend_model();

if(!empty($array['friends']) && !empty($array['username1']) && !empty($array['username2'])){
	if(preg_match($friend_model::$regular_expression['username'], $array['username1']) && preg_match($friend_model::$regular_expression['username'], $array['username2'])){
		$username1 = $array['username1'];
		$username2 = $array['username2'];
		
		$getusername1 = $friend_model->getUserName($username1);
		$getusername2 = $friend_model->getUserName($username2);
		$user_id = $getusername1['user_ID'];
		$friend_id = $getusername2['user_ID'];
		$status = $array['status'];
		
		if($status == 1){
			$friend_model->insertFriend($user_id, $friend_id);
			$friend_model->insertFriend($friend_id, $user_id);
			$friend_model->deleteFriendRequest($user_id);
			
			$response['code'] = 0;
			$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
			$friend_model->deliver_response($response);
		}
		else{
			$friend_model->deleteFriendRequest($user_id);
			
			$response['code'] = 12;
			$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
			$friend_model->deliver_response($response);
		}
	}
	else{
		$response['code'] = 15;
		$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
		$friend_model->deliver_response($response);
	}
}
else if(!empty($array['friendrequest']) && !empty($array['username1']) && !empty($array['username2'])){
	if(preg_match($friend_model::$regular_expression['username'], $array['username1']) && preg_match($friend_model::$regular_expression['username'], $array['username2'])){
		$username1 = $array['username1'];
		$username2 = $array['username2'];
		
		$getusername1 = $friend_model->getUserName($username1);
		$getusername2 = $friend_model->getUserName($username2);
		
		$user_id_1 = $getusername1['user_ID'];
		$user_id_2 = $getusername2['user_ID'];
		
		$friend_model->insertFriendRequest($user_id_1, $user_id_2);
		
		$response['code'] = 0;
		$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
		$friend_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
		$friend_model->deliver_response($response);
	}
}
else if(!empty($array['getfriendrequest']) && !empty($array['username2'])){
	if(preg_match($friend_model::$regular_expression['username'], $array['username2'])){
		$username2 = $array['username2'];
		
		$getusername2 = $friend_model->getUserName($username2);
		
		$user_id_2 = $getusername2['user_ID'];
		
		$data = array();
		$data = $friend_model->getFriendRequest($user_id_2);
		
		$response['code'] = 0;
		$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$friend_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
		$friend_model->deliver_response($response);
	}
}
else if(!empty($array['ktfriend']) && !empty($array['username1']) && !empty($array['username2'])){
	if(preg_match($friend_model::$regular_expression['username'], $array['username1']) && preg_match($friend_model::$regular_expression['username'], $array['username2'])){
		$username1 = $array['username1'];
		$username2 = $array['username2'];
		
		$getusername1 = $friend_model->getUserName($username1);
		$getusername2 = $friend_model->getUserName($username2);
		
		$user_id = $getusername1['user_ID'];
		$friend_id = $getusername2['user_ID'];
		
		$kt_friend = $friend_model->ktFriend($user_id, $friend_id);
		
		if($kt_friend == true){
			$response['code'] = 0;
			$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
			$friend_model->deliver_response($response);
		}
		else{
			$response['code'] = 10;
			$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
			$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
			$friend_model->deliver_response($response);
		}
	}
	else{
		$response['code'] = 15;
		$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
		$friend_model->deliver_response($response);
	}
}
else if(!empty($array['listfriend']) && !empty($array['user_id'])){
	if(preg_match($friend_model::$regular_expression['number'], $array['user_id'])){
		$user_id = $array['user_id'];
		$data = array();
		$data = $friend_model->listFriends($user_id);
		
		$response['code'] = 0;
		$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $data;
		$friend_model->deliver_response($response);
	}
	else{
		$response['code'] = 15;
		$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
		$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
		$friend_model->deliver_response($response);
	}
}
else{
	$response['code'] = 11;
	$response['status'] = $friend_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $friend_model::$api_response_code[ $response['code'] ]['Message'];
	$friend_model->deliver_response($response);
}
