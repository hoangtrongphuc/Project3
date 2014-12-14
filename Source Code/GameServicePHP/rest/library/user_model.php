<?php
class user_model extends model{
	protected $_user = "tbl_user";
	
	//login
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
		$sql = "select * from $this->_user where user_name='$username' and user_ban_mo='1'";
		$this->query($sql);
	
		if($this->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	//hàm tạo token
	//public  function getToken($pass){
	//	$token = md5($pass[0].$pass);
	//	return $token;
	//}
	//end-login
	
	//register
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
	public function insert($username, $pass, $gender, $email, $user_coin, $level, $ban_mo){
		$sql = "insert into $this->_user(user_name, user_pass, user_gender, user_email, user_coin, user_level, user_ban_mo)
		values('$username', '$pass', '$gender', '$email', '$user_coin', '$level', '$ban_mo')";
		$this->query($sql);
	}
	//end-register
	
	//forgot
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
	
	public function updatePassForGot($username, $newpass){
		$sql = "update $this->_user set user_pass='$newpass' where user_name='$username'";
		$this->query($sql);
	}
	//end-forgot
	
	//changeinfo
	//cập nhật lại pass khi người chơi đổi mật khẩu
	public function updateInfo($username, $pass, $fullname, $gender, $phone, $address, $email){
		if($pass == ""){
			$sql = "update $this->_user set user_fullName='$fullname',user_gender='$gender',user_tel='$phone',
					user_address='$address',user_email='$email' where user_name='$username'";
		}else{
			$sql = "update $this->_user set user_pass='$pass',user_fullName='$fullname',user_gender='$gender',user_tel='$phone',
					user_address='$address',user_email='$email' where user_name='$username'";
		}
		$this->query($sql);
	}
	//end-changeinfo
	
	//cập nhật lại kết quả trận đấu
	public function updateMatch($user_name, $total_win, $total_lose, $total_coin){
		if($total_win == ""){
			$sql = "update $this->_user
					set user_lose='$total_lose', user_coin='$total_coin'
					where user_name='$user_name'";
		}
		else if($total_lose == ""){
			$sql = "update $this->_user
					set user_win='$total_win', user_coin='$total_coin'
					where user_name='$user_name'";
		}
		$this->query($sql);
	}
	
	//logout update lại status
	public function updateStatusID($user_id, $status){
		$sql = "update $this->_user set user_status='$status' where user_ID='$user_id'";
		$this->query($sql);
	}
	
	//Update thông tin người chơi 
	public function updateUser($id, $user_name, $fullname, $gender, $telephone, $address, $email){
		$sql = "update $this->_user set user_name='$user_name', user_fullName='$fullname', 
										user_gender='$gender', user_tel='$telephone', user_address='$address', user_email='$email'
				where user_ID='$id'";
		$this->query($sql);
	}
	
	//updatestatus
	public function updateStatus($username, $status){
		$sql = "update $this->_user set user_status='1' where user_name='$username'";
		$this->query($sql);
	}
}