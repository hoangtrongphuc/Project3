<?php
$array = $_REQUEST;
$napxu_model = new napxu_model();

if(!empty($array['username']) && !empty($array['support']) && !empty($array['code']) && !empty($array['serial'])){
	$username = $array['username'];
	$support = $array['support'];
	$code = $array['code'];
	$serial = $array['serial'];
	
	$ktMaThe = $napxu_model->ktMaThe($support, $code, $serial);
	
	if($ktMaThe == true){
		$getUser = $napxu_model->getUser($username);
		$getXu = $napxu_model->getXu($serial);
		
		//tính tổng số xu
		$total_coin = $getUser['user_coin'] + $getXu['coin'];
		
		$napxu_model->updateXu($username, $total_coin);
		
		$napxu_model->deliver_response(0, "Nạp thẻ thành công", $username);
	}
	else{
		$napxu_model->deliver_response(12, "Sai mã thẻ nạp xu", $username);
	}
}
else{
	$napxu_model->deliver_response(10, "lỗi hệ thống", NULL);
}