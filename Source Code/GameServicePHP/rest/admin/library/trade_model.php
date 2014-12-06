<?php
class trade_model extends adminmodel{
	protected $_trade = "tbl_trade";
	protected  $_user = "tbl_user";
	
	public function listTrade($start, $limit){
		$sql = "select * from $this->_trade inner join $this->_user on $this->_trade.user_ID=$this->_user.user_ID limit $start,$limit";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	public function search($name){
		$sql = "select * from $this->_trade inner join $this->_user on $this->_trade.user_ID=$this->_user.user_ID where user_name like '%$name%'";
		$this->query($sql);
	
		return $this->fetchAll();
	}
}