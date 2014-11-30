<?php 
require_once 'class/tokenkey.php';

$tokenkey = new tokenkey();
$model = new model();

$getTokenkey = $tokenkey->getTokenkey();

//setCookie cho tokenkey
setcookie("coo_tokenkey",$getTokenkey,time()+3600*12);

$data = array(
		'tokenkey'=>$getTokenkey,
		'coo_tokenkey'=>$_COOKIE['coo_tokenkey']
		);
$model->deliver_response(0, "mã tokenkey", $data);

//Gửi tokenkey cho Game Server
