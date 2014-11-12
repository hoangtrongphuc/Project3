<?php
class register_model extends model{
	protected $_user = "tbl_user";
	
	//kiểm tra user_name và email lúc đăng ký
	public function kt($attr,$val){
		$sql = "select * from $this->_user where $attr = '$val'";
		$this->query($sql);
	
		if($this->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	//insert tài khoản vào database khi đăng kí thành công
	//level = 2 tài khoản thường, status = 2 tài khoản chưa bị ban
	public function insert($username, $pass, $email, $level, $status){
		$sql = "insert into $this->_user(user_name, user_pass, user_email, user_level, user_status) 
								values('$username', '$pass', '$email', '$level', '$status')";
		$this->query($sql);
	}
}