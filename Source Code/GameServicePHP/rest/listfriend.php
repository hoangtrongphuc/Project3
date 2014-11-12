<?php
require_once 'library/friend_model.php';

$friend_model = new friend_model();
$data = array();
$data = $friend_model->listFriends($user_id);

$friend_model->deliver_response(0, "danh sách bạn bè", $data);