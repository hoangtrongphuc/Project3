<?php
$array = $_REQUEST;
$friend_model = new friend_model();

if(!empty($array['user_id']) && !empty($array['friend_id']) && !empty($array['status'])){
	$user_id = $array['user_id'];
	$friend_id = $array['friend_id'];
	$status = $array['status'];
	
	if($status == 1){
		$friend_model->insertFriend($user_id, $friend_id);
		$friend_model->deleteFriendRequest($user_id);
		
		$friend_model->deliver_response(0, "đồng ý kết bạn", $user_id);
	}
	else{
		$friend_model->deleteFriendRequest($user_id);
		$friend_model->deliver_response(0, "hủy kết bạn", $user_id);
	}
}
else{
	$friend_model->deliver_response(10, "lỗi hệ thống", NULL);
}
