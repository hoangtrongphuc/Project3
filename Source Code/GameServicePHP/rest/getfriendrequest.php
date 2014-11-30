<?php
require_once 'library/friend_model.php';

$array = $_REQUEST;
$friend_model = new friend_model();

if(!empty($array['user_id_1'])){
	$user_id_1 = $array['user_id_1'];
	
	$data = array();
	$data = $friend_model->getFriendRequest($user_id_1);
	$friend_model->deliver_response(0, "danh sách đang chờ kết bạn", $data);
}
else{
	$friend_model->deliver_response(10, "lỗi hệ thống", NULL);
}