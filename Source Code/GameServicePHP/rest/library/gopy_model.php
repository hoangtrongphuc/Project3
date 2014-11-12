<?php
class gopy_model extends model{
	protected $_gopy = "gopy";
	
	//thêm góp ý váo database
	public function insertGopY($username,$noidung){
		$sql = "insert into $this->_gopy(noidung) values('$noidung')";
		$this->query($sql);
	}
}