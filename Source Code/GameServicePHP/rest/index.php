<?php
	header("Content-Type:application/json; charset=utf-8");
	require_once 'library/config.php';
	require_once 'library/database.php';
	require_once 'library/model.php';
	require_once 'library/login_model.php';
	require_once 'library/register_model.php';
	require_once 'library/forgot_model.php';
	require_once 'library/napxu_model.php';
	require_once 'library/changepass_model.php';
	require_once 'library/friend_model.php';
	require_once 'library/gopy_model.php';
	
	
	$array = array();
	$array = $_REQUEST;
	
	//$array1 = file_get_contents("php://input");
	//$array = json_decode($array1,true);
	
	if(!empty($array['api']) && $array['api'] == "tokenkey"){
		include 'tokenkey.php';
	}
	else if(!empty($array['api']) && $array['api'] == "login"){
		include 'login.php';
	}
	else if(!empty($array['api']) && $array['api'] == "register"){
		include 'register.php';
	}
	else if(!empty($array['api']) && $array['api'] == "toprank"){
		include 'toprank.php';
	}
	else if(!empty($array['api']) && $array['api'] == "toprick"){
		include 'toprick.php';
	}
	else if(!empty($array['api']) && $array['api'] == "friend"){
		include 'friend.php';
	}
	else if(!empty($array['api']) && $array['api'] == "friendrequest"){
		include 'friendrequest.php';
	}
	else if(!empty($array['api']) && $array['api'] == "forgot"){
		include 'forgot.php';
	}
	else if(!empty($array['api']) && $array['api'] == "changepass"){
		include 'changepass.php';
	}
	else if(!empty($array['api']) && $array['api'] == "napxu"){
		include 'napxu.php';
	}
	else if(!empty($array['api']) && $array['api'] == "gopy"){
		include 'gopy.php';
	}
	else if(!empty($array['api']) && $array['api'] == "logout"){
		include 'logout.php';
	}
	else{
		$model = new model();
		$model->deliver_response(1, "sai API", NULL);
	}
	
?>