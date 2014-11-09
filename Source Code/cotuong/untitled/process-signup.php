<?php require_once("libraries/user.php");?>
<?php 

$name = $_POST['name'];
$pass = $_POST['pass'];
$repass = $_POST['repass'];
$user = new user();

$checkpass = $user->checkpass($pass,$repass);
echo $checkpass;
if($checkpass == "false"){
	echo $name;
}else {
		echo $name;
		
	}