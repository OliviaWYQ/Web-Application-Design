<?php
// include shared code
include '../lib/common.php';

// start or join the session
session_start();
header('Cache-control: private');
header("Content-Type:text/html;charset=utf-8");
// issue 401 error if the user has not been authenticated
if (!isset($_SESSION['access']) || $_SESSION['access'] != TRUE)
{
    header('HTTP/1.0 401 Authorization Error');
    ob_start();
?>
<script type="text/javascript">
window.seconds = 10; 
window.onload = function()
{
    if (window.seconds != 0)
    {
        document.getElementById('secondsDisplay').innerHTML = '' +
            window.seconds + ' second' + ((window.seconds > 1) ? 's' : ''); 
        window.seconds--;
        setTimeout(window.onload, 1000);
    }
    else
    {
        window.location = 'index.php';
    }
}
</script>

<?php
    $GLOBALS['TEMPLATE']['extra_head'] = ob_get_contents();
    ob_clean();

?>
<style type="text/css">
body{
	
	width:1024px;
	height:768px;
	padding:200px 300px;
	background:#0FF;
	
}
</style>
<h1>ERROR</h1>
<p>无法为你提供你要访问的页面或资源，原因可能是你的访问权限不住，请先进行登陆获得访问权限.</p>

<p><strong>10秒后自动转向登陆界面 
<span id="secondsDisplay">10 seconds</span>.</strong></p>

<p>点击链接重新登陆后台
Link: <a href="index.php">登陆</a></p>
<?php
    $GLOBALS['TEMPLATE']['content'] = ob_get_clean();

    include '../templates/template-page.php';
    exit();
}
?>
