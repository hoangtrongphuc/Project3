<?php
class event_model extends model{
	protected $_event = "tbl_event";
	
	public function listEvent(){
		$sql = "select * from $this->_event";
		$this->query($sql);
		
		return $this->fetchAll();
	}
}