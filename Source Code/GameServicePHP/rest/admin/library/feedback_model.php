<?php
class feedback_model extends adminmodel{
	protected $_feedback = "tbl_feedback";
	protected $_user = "tbl_user";
	
	public function listFeedBack($start, $limit){
		$sql = "select * from $this->_feedback inner join $this->_user on $this->_feedback.user_ID=$this->_user.user_ID limit $start,$limit";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	public function deleteFeedBack($id){
		$sql = "delete from $this->_feedback where feedback_ID='$id'";
		$this->query($sql);
	}
}