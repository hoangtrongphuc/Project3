<?php
class database{
	protected $db = "";
	protected $_result = "";
	public function __construct(){
		$this->db = mysql_connect(config::HOST,config::USER,config::PASS) or die("Can not connect database"); 
		mysql_select_db(config::DATABASE,$this->db);
		mysql_query("SET NAMES utf8");
	}
	
	public function query($sql){
		$this->_result = mysql_query($sql);
	}
	public function num_rows(){
		if($this->_result){
			$rows = mysql_num_rows($this->_result);
		}else{
			$rows = 0;
		}
		return $rows;
	}
	public function fetch(){
		$data = array();
		if($this->_result){
			$data = mysql_fetch_assoc($this->_result);
		}
		return $data;
	}
	public function fetchAll(){
		$data = array();
		if($this->_result){
			while($row = mysql_fetch_assoc($this->_result)){
				$data[] = $row;
			}
		}
		return $data;
	}
}