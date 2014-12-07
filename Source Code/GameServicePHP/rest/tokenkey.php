<?php 
require_once 'class/tokenkey.php';

$tokenkey = new tokenkey();
$model = new model();
/* 
if(isset($_COOKIE['cookie_tokenkey'])){
	$response['code'] = 24;
	$response['status'] = $model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $model::$api_response_code[ $response['code']]['Message'];
	$model->deliver_response($response);
}
else{ */
	$getTokenkey = $tokenkey->getTokenkey();
	
	//setCookie cho tokenkey
	$_COOKIE["cookie_tokenkey"] = $getTokenkey;
	setcookie("cookie_tokenkey", $_COOKIE["cookie_tokenkey"], time()+3600*24,"/");
	$data = array('tokenkey'=>$getTokenkey);
	
	$response['code'] = 0;
	$response['status'] = $model::$api_response_code[ $response['code'] ]['HTTP Response'];
	$response['data'] = $data;
	$model->deliver_response($response);
//}
