<?php
class changepass_model extends model{
	protected $_user = "tbl_user";
	
	//cập nhật lại pass khi người chơi đổi mật khẩu
	public function updatePass($user_name, $user_pass){
		$sql = "update $this->_user set user_pass='$user_pass' where user_name='$user_name'";
		$this->query($sql);
	}
}