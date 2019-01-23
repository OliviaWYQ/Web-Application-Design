<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统登陆</title>
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function check()
{
	if(document.login.username.value == "")
	{
		alert("用户名不能为空");
		document.login.username.focus();
		return false;
	}
	else if(document.login.password.value == "")
	{
		alert("密码不能为空");
		document.login.password.focus();
		return false;
	}
	else if(document.login.verify.value == "")
	{
		alert("输入验证码");
		document.login.verify.focus();
		return false;
	}
	document.login.submit()
}
</script>
</head>
<body>
<div id="login">
<form method="post" action="Admin_login.php?login" name="login" onsubmit="return check()">
<?php
echo "<div style=\"margin-left:-90px;
    margin-top:-60px; width:300px;height:220px;background-color:rgba(10%,20%,30%,0.2);\"></div>";
?>
<ul>
<li><span>NAME:</span><input type="text" name="username" maxlength="20" /></li>
<li><span>KEY:</span><input type="password" name="password"  /></li></li>
<li id="login_verify"><span>CODE：</span><input type="text" name="verify"  maxlength="5" /><img src="../images/captcha.php" /></li>
<li id="login_btn_li"><input type="submit" value="login"  class="login_btn"/><input name="reset" type="reset" value="reset" class="login_btn" /></li>
</ul>
</form>
</div>
<?php include 'Admin_bottom.php';?>
</body>
</html>