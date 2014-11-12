<?php
session_start();

$array = $_REQUEST;
$login_model = new login_model();

if(!empty($array['username']) && !empty($array['pass']) && !empty($array['signal'])){

	$username = $array['username'];
	$pass = $array['pass'];
	$signal = $array['signal'];
	
	$tokenkey = $_COOKIE['coo_tokenkey'];
	
	$tmp_signal = md5($username.$pass.$tokenkey);
	
	$checkuser = $login_model->checkUser($username);
	if($checkuser == false){
		if($tmp_signal == $signal){
		
			$checklogin = $login_model->checkLogin($username, $pass);
			if($checklogin == false){
				$login_model->deliver_response(3,"thất bại",$username);
			}else{
				//url của Game Server
				$url = url;
				$md5_url = md5($url);
					
				//tạo sesion					
				$_SESSION['ses_userid'] = $checklogin['user_id'];
				$_SESSION['ses_name'] = $checklogin['user_name'];
				$_SESSION['ses_level'] = $checklogin['user_level'];
					
				$data = array(
						'url'=>$url,
						'md5_url'=>$md5_url,
						'ses_id'=>$_SESSION['ses_id'],
						'ses_name'=>$_SESSION['ses_name'],
						'ses_level'=>$_SESSION['ses_level']
				);
					
				$login_model->deliver_response(0,"thành công",$data);
				
				//gửi id username cho Game Server
							
			}
		}
		else{
			$login_model->deliver_response(2,"sai signal",$username);
		}
	}
	else{
		$login_model->deliver_response(4, "tài khoản bị ban", $username);
	}
}
else{
	$login_model->deliver_response(10, "lỗi hệ thống", NULL);
}