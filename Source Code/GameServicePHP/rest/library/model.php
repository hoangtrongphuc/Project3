<?php
class model extends database{
	protected $_user = "tbl_user";
	protected $_tokenkey = "tbl_tokenkey";
	protected  $_friends = "tbl_friends";
	
	//lấy danh sách topRank
	public function topRank(){
		$sql = "select * from $this->_user order by user_win limit 0,5";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	//lấy danh sách topRick
	public function topRick(){
		$sql = "select * from $this->_user order by user_coin limit 0,5";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	
	//lấy danh sách thông tin người chơi
	public function listUser($user_name){
		$sql = "select * from $this->_user where user_name='$user_name'";
		$this->query($sql);
		
		return $this->fetch();
	}
	
	
	//gói tin json gửi nhận giữa client - service
	public function deliver_response($code,$message,$data){
		header("HTTP/1.1 $code $message");
		$response['code'] = $code;
		$response['message'] = $message;
		$response['data'] = $data;
	
		$json_response = json_encode($response,true);
		echo $json_response;
	}
}
?>