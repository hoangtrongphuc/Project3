<?php
class tokenkey{
	
	public function getTokenkey(){
		$time = time();
		$rand = rand(100, 1000000);
		$tokenkey = md5($time.$rand);
		
		return $tokenkey;
	}
}