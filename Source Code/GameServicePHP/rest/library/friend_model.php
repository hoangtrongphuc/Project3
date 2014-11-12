<?php
class friend_model extends model{
	protected $_friend = "tbl_friends";
	protected $_friend_request = "tbl_frined_request";
	
	//kiểm tra danh sách bạn bè
	public function ktFriend($user_id, $friend_id){
		$sql = "select * from $this->_friend where user_ID='$user_id' and friend_ID='$friend_id'";
		$this->query($sql);
		
		if($this->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	//lấy danh sách thông tin bạn bè
	public function listFriends($user_id){
		$sql = "select * from $this->_friends where user_ID='$user_id'";
		$this->query($sql);
	
		return $this->fetchAll();
	}
	
	//nếu ktFriend = false thực hiện gửi kết bạn
	public function insertFriendRequest($user_id, $friend_id){
		$sql = "insert into $this->_friend_request(user_id_1, friend_id_2) values('$user_id','$friend_id')";
		$this->query($sql);
	}
	
	//get lấy list FriendRequest
	public function getFriendRequest($user_id_1){
		$sql = "select * from $this->_friend_request where user_id_1='$user_id_1'";
		$this->query($sql);
		
		return $this->fetchAll();
	}
	
	//Nếu user2 đồng ý kết bạn
	public function insertFriend($user_id, $friend_id){
		$sql = "insert into $this->_friend(user_ID, friend_ID) values('$user_id', '$friend_id')";
		$this->query($sql);
	}
	
	//Hủy kết bạn khi user2 không đồng ý
	public function deleteFriendRequest($user_id_1){
		$sql = "delete from $this->_friend_request where user_id_1='$user_id_1'";
		$this->query($sql);
	}
	
	//bỏ kết bạn sau 1 thời gian đã là bạn bè
	public function deleteFriend($user_id){
		$sql = "delete from $this->_friend where user_ID='$user_id'";
		$this->query($sql);
	}
}