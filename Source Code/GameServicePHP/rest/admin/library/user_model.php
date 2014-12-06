<?php
class user_model extends adminmodel{
	protected $_user = "tbl_user";
	
	//kiểm tra login với tài khoản admin
	public function checklogin($username, $pass){
		$sql = "select * from $this->_user where user_name='$username' and user_pass='$pass' and user_level='1'";
		$this->query($sql);
		
		if($this->num_rows() > 0){
			return $this->fetch();
		}
		else{
			return false;
		}
	}
	//kiểm tra user và email tồn tại chưa
	public function checkUserEmail($key, $value){
		$sql = "select * from $this->_user where $key='$value'";
		$this->query($sql);
		
		if($this->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function updateStatus($user_name, $status){
		$sql = "update $this->_user set user_status='$status' where user_name='$user_name'";
		$this->query($sql);
	}
	//lấy danh sách user
	public function listUser($start, $limit){
		$sql = "select * from $this->_user limit $start,$limit";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	//thêm tài khoản
	public function insert($username, $pass, $fullname, $gender, $telephone, $address, $email, $level, $coin, $status, $ban_mo){
		$sql = "insert into $this->_user(user_name, user_pass, user_fullName, user_gender, user_tel, user_address, user_email, user_level, user_coin, user_status, user_ban_mo)
							values('$username', '$pass', '$fullname', '$gender', '$telephone', '$address', '$email', '$level', '$coin', '$status', '$ban_mo')";
		$this->query($sql);
	}
	
	//xóa tài khoản
	public function delete($id){
		$sql = "delete from $this->_user where user_id='$id'";
		$this->query($sql);
	}
	
	//Ban tài khoản hay đóng tài khoản lại
	//user_ban_mo = 1 bị ban, user_ban_mo = 2 không bị ban
	public function banUser($id){
		$sql = "update $this->_user set user_ban_mo='1' where user_id='$id'";
		$this->query($sql);
	}
	
	//Mở tài khoản trở lại
	public function moUser($id){
		$sql = "update $this->_user set user_ban_mo='2' where user_id='$id'";
		$this->query($sql);
	}
	
	//get user
	public function getUser($id){
		$sql = "select * from $this->_user where user_id='$id'";
		$this->query($sql);
		
		return $this->fetch();
	}
	
	//lấy 5 danh sách mới 
	public function listUserHome($start, $limit){
		$sql = "select * from $this->_user order by user_ID desc limit $start,$limit";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	//update lại xu sau khi thưởng xu
	public function updateXu($id, $total_xu){
		$sql = "update $this->_user set user_coin='$total_xu' where user_id='$id'";
		$this->query($sql);
	}
	
	//tìm kiếm tài khoản
	public function search($username){
		$sql = "select * from $this->_user where user_name like '%$username%'";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	//logout update lại status
	public function updateStatusID($user_id, $status){
		$sql = "update $this->_user set user_status='$status' where user_ID='$user_id'";
		$this->query($sql);
	}
}