<?php
class thongke_model extends adminmodel{
	protected $_user = "tbl_user";
	protected $_napxu = "tbl_napxu";
	protected $_feedback = "tbl_feedback";
	protected $_event = "tbl_event";
	protected $_trade = "tbl_trade";
	
	//số lượng user hiện tại
	public function countUser(){
		$sql = "select * from $this->_user";
		$this->query($sql);
		
		return $this->num_rows();
	}
	//số tài khoản đang online
	public function countUserOnline(){
		$sql = "select * from $this->_user where user_status='1'";
		$this->query($sql);
	
		return $this->num_rows();
	}
	
	//số lượng user bị ban
	//status = 1 bị ban, status = 2 không bị ban
	public function countUserBan(){
		$sql = "select * from $this->_user where user_ban_mo='1'";
		$this->query($sql);
		
		return $this->num_rows();
	}
	
	//số người chơi tại 1 thời điểm
	public function countUserTime(){
		$sql = "select * from $this->_user where user_status='1'";
		$this->query($sql);
		
		return $this->num_rows();
	}
	
	//thống kê doanh thu theo tháng
	public function incomeMonth(){
		$sql = "select trade_month,sum(trade_coin) as trade_coin,count(trade_month) as quantity_month,trade_year
				from (
				 	select extract(month from trade_date) as trade_month,extract(year from trade_date) as trade_year,trade_coin 
					from $this->_trade
					) as X
			group by trade_month,trade_year
			order by trade_year,trade_month asc";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	//thống kê doanh thu theo năm 
	public function incomeYear(){
		$sql = "select trade_year,sum(trade_coin) as trade_coin,count(trade_year) as quantity_year
		from (
		select extract(year from trade_date) as trade_year,trade_coin
		from $this->_trade
		) as X
		group by trade_year";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	//user nạp tiền nhiều nhất
	public function userNapXuMax(){
		$sql = "select user_name,sum(trade_coin) as trade_coin,count(user_name) as user_quantity
		from $this->_trade inner join $this->_user on $this->_trade.user_ID = $this->_user.user_ID
		group by user_name
		order by trade_coin desc limit 0,1";
		$this->query($sql);
	
		return $this->fetchAll();
	}
	
	//thống kê feedback
	public function countFeedBack(){
		$sql = "select * from $this->_feedback";
		$this->query($sql);
		
		return $this->num_rows();
	}
	//thống kê event
	public function countEvent(){
		$sql = "select * from $this->_event";
		$this->query($sql);
	
		return $this->num_rows();
	}
}