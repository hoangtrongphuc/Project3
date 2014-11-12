<?php
require_once 'library/friend_model.php';

$array = $_REQUEST;
$friend_model = new friend_model();

if(!empty($array['user_id_1']) && !empty($array['user_id_2'])){
	$user_id_1 = $array['user_id_1'];
	$user_id_2 = $array['user_id_2'];
	
	$friend_model->insertFriendRequest($user_id_1, $user_id_2);
	$friend_model->deliver_response(0, "đang chờ kết bạn", $user_id_1);
}
else{
	$friend_model->deliver_response(10, "lỗi hệ thống", NULL);
}