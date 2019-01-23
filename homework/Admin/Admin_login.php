<?php
// include shared code
include '../lib/common.php';
include '../lib/db.php';
include '../lib/functions.php';
include '../lib/User.php';
include_once '../lib/WriteLog.php';
// start or continue the session
session_start();
header('Cache-control: private');

// perform login logic if login is set
if (isset($_GET['login']))
{
	if(!isset($_POST['verify']))
	{
		goback("请输入验证码!");
		exit();
	}
	if($_SESSION['captcha']!=$_POST['verify'])
	{
		goback("验证码错误!");
		exit();
	}
    if (isset($_POST['username']) && isset($_POST['password'])&&$_SESSION['captcha']==$_POST['verify'])
    {
        // retrieve user record
        $user = (User::getByUsername($_POST['username'])) ?User::getByUsername($_POST['username']) : new User();
		
        if ($user->uid && ($user->userpassword == ($_POST['password'])))
        {		
            
            $_SESSION['access'] = TRUE;
			if($user->isSuper) 
			{
				$_SESSION['super']=TRUE;
			}
            $_SESSION['userId'] = $user->uid;
            $_SESSION['username'] = $user->username;
			Log::WriteLog(6,$user->username);
            header('Location: Admin_index.php');
        }
        else
        {
            // invalid user and/or password
			$_SESSION['access'] = FALSE;
            $_SESSION['username'] = null;
		    $notice="用户名:".$_POST['username']."密码:".$_POST['password']." 登陆失败";
			Log::WriteLog(7,$notice);
			header('Location: 401.php');
        } 
    }
    // missing credentials
    else
    {
        $_SESSION['access'] = FALSE;
        $_SESSION['username'] = null;
		$notice="用户名:".$_POST['username']."密码:".$_POST['password']." 登陆失败";
		Log::WriteLog(7,$notice);
		header('Location: 401.php');
    }
    exit();
}

// perform logout logic if logout is set
// (clearing the session data effectively logsout the user)
else if (isset($_GET['logout']))
{
    if (isset($_COOKIE[session_name()]))
    {
        setcookie(session_name(), '', time() - 42000, '/');
    }

    $_SESSION = array();
    session_unset();
    session_destroy();
	header('Location: Index.php');
	exit();
}
?>
