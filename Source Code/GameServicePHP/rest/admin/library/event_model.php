<?php
class event_model extends adminmodel{
	protected $_event = "tbl_event";
	
	public function listEvent($start, $limit){
		$sql = "select * from $this->_event limit $start,$limit";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	public function getEvent($id){
		$sql = "select * from $this->_event where event_ID='$id'";
		$this->query($sql);
		
		return $this->fetch();
	}
	
	//kiểm tra tiêu đề có tồn tại chưa
	public function checkTitle($id, $title){
		$sql = "select * from $this->_event where event_title='$title' and event_ID!='$id'";
		$this->query($sql);
		
		if($this->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	//lấy ra danh sách sự kiện cho trang home
	public function listEventHome($start , $limit){
		$sql = "select * from $this->_event order by event_ID desc limit $start,$limit";
		$this->query($sql);
	
		return $this->fetchAll();
	}
	
	public function insert($title, $info, $status, $start, $finish){
		$sql = "insert into $this->_event(event_title, event_info, event_status, event_start, event_finish) values('$title', '$info', '$status', '$start', '$finish')";
		$this->query($sql);
	}
	
	public function edit($id, $title, $info, $start, $finish){
		$sql = "update $this->_event set event_title='$title',event_info='$info',event_start='$start',event_finish='$finish' where event_ID='$id'";
		$this->query($sql);
	}
	
	public function delete($id){
		$sql = "delete from $this->_event where event_ID='$id'";
		$this->query($sql);
	}
	
	public function search($name){
		$sql = "select * from $this->_event where event_title like '%$name%'";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	public function showEvent($id){
		$sql = "update $this->_event set event_status='1' where event_ID='$id'";
		$this->query($sql);
	}
	
	public function hideEvent($id){
		$sql = "update $this->_event set event_status='0' where event_ID='$id'";
		$this->query($sql);
	}
}