<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../add-in/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="../add-in/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="../CSS/newroom.css" />
<script type="text/javascript" src="../Javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../Javascript/newroom.js"></script>


<title>New - room</title>
</head>

<body>
<div id="content">
	<div id="title"><h2>Thông tin phòng chơi</h2></div>
    <div id="main">
    	<form role="form">
  <div class="form-group">
    <label for="exampleInputEmail1">Tên phòng chơi</label>
    <input type="text" class="form-control" id="roomname" placeholder="Tên phòng chơi">
  </div>
   <div class="checkbox">
    <label>
      <input type="checkbox" id="checkbox1"> Có mật khẩu
    </label>
  </div>
  <div class="form-group">
    <label for="pass">Password</label>
    <input type="password" class="form-control" id="pass" placeholder="Password"  >
  </div>
 <select class="form-control">
  <option>10000</option>
  <option>20000</option>
  <option>30000</option>
  <option>40000</option>
  <option>50000</option>
</select>

  <button type="submit" class="btn btn-success">Submit</button>
  
</form>
    </div>
</div>
</body>
</html>