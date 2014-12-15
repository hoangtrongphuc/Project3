<?php
class model extends database{
	protected $_user = "tbl_user";
	protected  $_friends = "tbl_friends";
	public static $regular_expression = array(
			'string' => '/^[a-zA-Z0-9]*$/',
			'number' => '/^[0-9]*$/',
			'username'=> '/^[a-zA-Z0-9]\w+[a-zA-Z0-9]*$/',
			'pass'  => '/^[a-zA-Z0-9]+$/',
			'email' => '/^[a-z]{1}[a-zA-Z0-9.]{2,}@[a-zA-Z0-9-_]{2,10}\.[a-zA-Z]{2,5}$/',
			'phone' => '/^0[0-9]{9,10}$/'
	);
	public static $api_response_code = array(
			0 => array('HTTP Response' => 200, 'Message' => 'Success'),
			1 => array('HTTP Response' => 200, 'Message' => 'Tham số API sai'),
			2 => array('HTTP Response' => 200, 'Message' => 'Sai Signal'),
			3 => array('HTTP Response' => 200, 'Message' => 'Sai Pass or Username'),
			4 => array('HTTP Response' => 200, 'Message' => 'User bị Ban'),
			5 => array('HTTP Response' => 200, 'Message' => 'User đã tồn tại, không được thêm mới'),
			6 => array('HTTP Response' => 200, 'Message' => 'User đang được sử dụng'),
			7 => array('HTTP Response' => 200, 'Message' => 'Email đã tồn tại'),
			8 => array('HTTP Response' => 200, 'Message' => 'Username hoặc Email không đúng'),
			9 => array('HTTP Response' => 200, 'Message' => 'Sai mã thẻ nạp xu'),
			10 => array('HTTP Response' => 200, 'Message' => 'Chưa là bạn bè'),
			11 => array('HTTP Response' => 200, 'Message' => 'Lỗi hệ thống'),
			12 => array('HTTP Response' => 200, 'Message' => 'Không chấp nhận kết bạn'),
			13 => array('HTTP Response' => 200, 'Message' => 'Đã tồn tại tiêu đề'),
			14 => array('HTTP Response' => 200, 'Message' => 'Bạn không đủ xu'),
			15 => array('HTTP Response' => 200, 'Message' => 'Lỗi dữ liệu'),
			16 => array('HTTP Response' => 200, 'Message' => 'Lỗi send mail'),
			17 => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
			18 => array('HTTP Response' => 403, 'Message' => 'HTTPS Required'),
			19 => array('HTTP Response' => 401, 'Message' => 'Authentication Required'),
			20 => array('HTTP Response' => 401, 'Message' => 'Authentication Failed'),
			21 => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
			22 => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format'),
			23 => array('HTTP Response' => 200, 'Message' => 'Lỗi khác'),
			24 => array('HTTP Response' => 200, 'Message' => 'Đã tồn tại cookie'),
	);
	
	//lấy danh sách topRank
	public function topRank(){
		$sql = "select * from $this->_user order by user_win desc limit 0,8";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	//lấy danh sách topRick
	public function topRick(){
		$sql = "select * from $this->_user order by user_coin desc limit 0,8";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	
	//lấy danh sách thông tin người chơi
	public function getUser($user_id){
		$sql = "select * from $this->_user where user_ID='$user_id'";
		$this->query($sql);
		
		return $this->fetch();
	}
	
	//getUserName
	public function getUserName($username){
		$sql = "select * from $this->_user where user_name='$username'";
		$this->query($sql);
	
		return $this->fetch();
	}
	
	
	//gói tin json gửi nhận giữa client - service
	public function deliver_response($response){
		$http_response_code = array(
				200 => 'OK',
				400 => 'Bad Request',
				401 => 'Unauthorized',
				403 => 'Forbidden',
				404 => 'Not Found',
		);
		
		header('HTTP/1.1 '.$response['status'].' '.$http_response_code[ $response['status'] ]);
		header('Content-Type: application/json; charset=utf-8');
		
		$json_response = json_encode($response);
		echo $json_response;
	}
}
?>