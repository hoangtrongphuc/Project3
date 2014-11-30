<?php
class forgot_model extends model{
	protected $_user = "tbl_user";
	
	//Kiểm tra user_name, email lúc quên mật khẩu
	public function ktEmail($user_name,$user_email){
		$sql = "select * from $this->_user where user_name='$user_name' and user_email='$user_email'";
		$this->query($sql);
	
		if($this->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	//update lại pass vào database khi user quên mật khẩu
	public function updatePass($user_name,$user_pass){
		$sql = "update $this->_user set user_pass='$user_pass' where user_name='$user_name'";
		$this->query($sql);
	}
}