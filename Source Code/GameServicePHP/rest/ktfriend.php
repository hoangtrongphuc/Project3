<?php
require_once 'library/friend_model.php';

$array = $_REQUEST;
$friend_model = new friend_model();

if(!empty($array['user_id']) && !empty($array['friend_id'])){
	$user_id = $array['user_id'];
	$friend_id = $array['friend_id'];
	
	$kt_friend = $friend_model->ktFriend($user_id, $friend_id);
	
	if($kt_friend == true){
		$friend_model->deliver_response(0, "là bạn bè", $user_id);
	}
	else{
		$friend_model->deliver_response(13, "chưa là bạn bè", $user_id);
	}
}
else{
	$friend_model->deliver_response(10, "lỗi hệ thống", NULL);
}