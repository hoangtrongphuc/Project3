<?php
class feedback_model extends model{
	protected $_feedback = "tbl_feedback";
	
	//thêm góp ý váo database
	public function insertFeedBack($id, $title, $info, $date){
		$sql = "insert into $this->_feedback(user_ID, feedback_title, feedback_info, feedback_date) 
				values('$id', '$title', '$info', '$date')";
		$this->query($sql);
	}
}