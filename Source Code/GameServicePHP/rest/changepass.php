<?php
$array = $_REQUEST;
$changepass = new changepass_model();

if(!empty($array['user_name']) && !empty($array['user_pass'])){
	$username = $array['user_name'];
	$pass = $array['user_pass'];
	
	$changepass->updatePass($username, $pass);
	$changepass->deliver_response(0, "đổi mật khẩu thành công", $username);
}
else{
	$changepass->deliver_response(10, "lỗi hệ thống", NULL);
}