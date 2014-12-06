<?php
require("lib/PHPMailer-master/class.phpmailer.php"); 
require("lib/PHPMailer-master/class.smtp.php"); 
define('GUSER', 'nguyenkhacnhatbk@gmail.com'); // tài khoản đăng nhập Gmail
define('GPWD', 'nhatduongchj'); // mật khẩu cho cái mail này  
 
class sendmail{
	static $error;
	function smtpmailer($to, $from, $from_name, $subject, $body) {
		global $error;
		$mail = new PHPMailer();  // tạo một đối tượng mới từ class PHPMailer
		$mail->IsSMTP(); // bật chức năng SMTP
		$mail->SMTPDebug = 0;  // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
		$mail->SMTPAuth = true;  // bật chức năng đăng nhập vào SMTP này
		$mail->SMTPSecure = 'ssl'; // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->Username = GUSER;
		$mail->Password = GPWD;
		$mail->SetFrom($from, $from_name);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($to);
		if(!$mail->Send()) {
			$error = 'Gửi mail bị lỗi: '.$mail->ErrorInfo;
			return false;
		} else {
			$error = 'Thư của bạn đã được gửi đi ';
			return true;
		}
	}
}


