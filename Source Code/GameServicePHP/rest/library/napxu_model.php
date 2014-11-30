<?php
class napxu_model extends model{
	protected $_napxu = "napxu";
	protected $_user = "user";
	
	//kiểm tra nhà cung cấp và mã thẻ
	public function ktMaThe($support, $code, $serial){
		$sql = "select * from $this->_napxu where support='$support' and code='$code' and  serial='$serial'";
		$this->query($sql);
		
		if($this->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	//lấy ra số tiền sẽ được nạp có trong bảng napxu
	public function getXu($serial){
		$sql = "select * from $this->_napxu where serial='$serial'";
		$this->query($sql);
		
		return $this->fetch();
	}
	
	//lấy ra thông tin của user khi nạp thẻ thành công để thực hiện cộng thêm xu
	public function getUser($user_name){
		$sql = "select * from $this->_user where user_name='$user_name'";
		$this->query($sql);
		
		return $this->fetch();
	}
	
	//thêm xu cho user khi nạp thẻ thành công
	public function updateXu($user_name,$total_coin){
		$sql = "update $this->_user set user_coin='$total_coin' where user_name='$user_name'";
		$this->query($sql);
	}
	
}