<?php
require_once 'class/sendToken.php';
//$array = $_REQUEST;
$user_model = new user_model();

if(!empty($array['username']) && !empty($array['pass']) && !empty($array['signal'])){
	if(preg_match($user_model::$regular_expression['username'], $array['username']) && preg_match($user_model::$regular_expression['pass'], $array['pass'])
			&& preg_match($user_model::$regular_expression['string'], $array['signal'])){
		$username = $array['username'];
		$pass = $array['pass'];
		$signal = $array['signal'];
		
		//lấy tokenkey đã đc setcookie
		$tokenkey = $_COOKIE['cookie_tokenkey'];
		
		//tạo mã signal để kiểm tra
		$tmp_signal = md5($username.$pass.$tokenkey);
		//echo $tmp_signal;
		//kiểm tra username có bị ban không
		$checkuser = $user_model->checkUser($username);
		
		//thêm bit muối cho pass
		//$pass = $pass[0].$pass;
		
		if($checkuser == false){
			if($tmp_signal == $signal){
				//kiểm tra username và pass có hợp lệ không
				$checkLogin = $user_model->checkLogin($username, $pass);
				if($checkLogin == false){
					$response['code'] = 3;
					$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
					$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
					$user_model->deliver_response($response);
				}else{
						
					//tạo cookie				
					$_COOKIE['cookie_id'] = $checkLogin['user_ID'];
					$_COOKIE['cookie_username'] = $checkLogin['user_name'];
					$_COOKIE['cookie_level'] = $checkLogin['user_level'];
					setcookie("cookie_id", $_COOKIE['cookie_id'], time() + 3600*24, "/");
					setcookie("cookie_username", $_COOKIE['cookie_username'], time() + 3600*24, "/");
					setcookie("cookie_level", $_COOKIE['cookie_level'], time() + 3600*24, "/");
					
					//tạo token
// 					$token = $user_model->getToken($pass);
// 					$data = array(
// 							'token'=>$token
// 					);
					//update status = 1 đang online
					$user_model->updateStatus($username, '1');
					
					$response['code'] = 0;
					$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
					$response['data'] =  $user_model::$api_response_code[ $response['code'] ]['Message'];
					$user_model->deliver_response($response);
					
					//gửi id username và token cho Game Server
					
					$ulti = new ulti();
					$ulti->sendToken($tokenkey);
				}
			}
			else{
				$response['code'] = 2;
				$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
				$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];
				$user_model->deliver_response($response);
			}
		}
		else{
			$response['code'] = 4;
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
else{
	$response['code'] = 11;
	$response['status'] = $user_model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $user_model::$api_response_code[ $response['code'] ]['Message'];		
	$user_model->deliver_response($response);
}