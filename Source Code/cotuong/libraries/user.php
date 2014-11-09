<?php
class user{
public function checkpass($pass,$repass){
		//return strlen($pass);
		if(strlen($pass) >= 5 && strlen($pass) <= 33){
		if($pass != $repass)
		return "false";
		else return "true";
	}
		else return "false";
	}
	
	public function checkemail($email){
		$mailrule = "/^[a-z]{1}[a-zA-Z0-9.]{2,}@[a-zA-Z0-9]{2,5}\.[a-zA-Z0-9]{2,5}$/";
		if(preg_match($mailrule,$email)){
		 return "true";
		}
		else return "false";
	}
}
?>