<?php
$array = $_REQUEST;
$gopy_model = new gopy_model();

if(!empty($array['username']) && !empty($array['noidung'])){
	$username = $array['username'];
	$noidung = $array['noidung'];

	$gopy_model->insertGopY($username, $noidung);
	$gopy_model->deliver_response(0, "góp ý thành công", $username);
}
else{
	$gopy_model->deliver_response(10, "lỗi hệ thống", NULL);
}