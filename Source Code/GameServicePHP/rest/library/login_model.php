<?php
class login_model extends model{
	protected $_user = "tbl_user";
	
	//kiểm tra username, password lúc đăng nhập
	public function checkLogin($user,$pass){
		$sql = "select * from $this->_user where user_name = '$user' and user_pass = '$pass'";
		$this->query($sql);
	
		if($this->num_rows() > 0){
			return $this->fetch();
		}else{
			return false;
		}
	}
	
	
	//kiểm tra tài khoản có bị ban không
	//status = 1 bị ban, status = 2 không bị ban
	public function checkUser($username){
		$sql = "select * from $this->_user where user_name='$username' and user_status='1'";
		$this->query($sql);
		
		if($this->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
}