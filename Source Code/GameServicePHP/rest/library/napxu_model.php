<?php
class napxu_model extends model{
	protected $_napxu = "tbl_examplecard";
	protected $_user = "tbl_user";
	protected $_trade = "tbl_trade";
	
	//kiểm tra nhà cung cấp và mã thẻ
	public function ktMaThe($provider, $code, $serial){
		$sql = "select * from $this->_napxu where card_provider='$provider' and card_code='$code' and  card_serial='$serial' and card_status='2'";
		$this->query($sql);
		
		if($this->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	//insert trade
	public function insertTrade($id, $provider, $serial, $code, $coin, $date){
		$sql = "insert into $this->_trade(user_ID, trade_provider, trade_serial, trade_code, trade_coin, trade_date)
				values('$id', '$provider', '$serial', '$code', '$coin', '$date')";
		$this->query($sql);
	}
	
	//lấy ra số tiền sẽ được nạp có trong bảng napxu
	public function getXu($serial){
		$sql = "select * from $this->_napxu where card_serial='$serial'";
		$this->query($sql);
		
		return $this->fetch();
	}
	
	//lấy ra thông tin của user khi nạp thẻ thành công để thực hiện cộng thêm xu
	public function getUser($feil, $value){
		$sql = "select * from $this->_user where $feil='$value'";
		$this->query($sql);
		
		return $this->fetch();
	}
	
	//check xu để đc vào phòng chơi
	public function checkXu($id, $coin){
		$sql = "select * from $this->_user where user_ID='$id' and user_coin>='$coin'";
		$this->query($sql);
		
		if($this->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	//thêm xu cho user khi nạp thẻ thành công
	public function updateXu($user_id,$total_coin){
		$sql = "update $this->_user set user_coin='$total_coin' where user_ID='$user_id'";
		$this->query($sql);
	}
	
	//update status=1 khi nạp thẻ thành công -> thẻ chỉ đc nạp 1 lần
	public function updateCardStatus($id, $status) {
		$sql = "update $this->_napxu set card_status='$status' where card_ID='$id'";
		$this->query($sql);
	}
	
}