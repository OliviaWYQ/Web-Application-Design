<?php
  //include shared code
   include '401.php';
   include '../lib/db.php';
  //----------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<script language="javaScript">
function setCheck(id){
if(id.checked)
alert("dd");
}
</script>
</head>
<body>
<div id="main">
  <div id="config_left">
    <?php
include '../lib/GetServerInfo.php';
?>
    <div id="config_info">
      <h2>网站服务器信息:</h2>
      <?php
date_default_timezone_set('PRC');
$ServerInfo = new ServerInfo();
$rs .= '<ul><li>'.'服务器时间：'.$ServerInfo->GetServerTime().'</li>';
$rs .= '<li>'.'服务器解译引擎：'.$ServerInfo->GetServerSoftwares().'</li>';
$rs .= '<li>'.'PHP版本：'.$ServerInfo->GetPhpVersion().'</li>';
$rs .= '<li>'.'MYSQL版本：'.$ServerInfo->GetMysqlVersion().'</li>';
$rs .= '<li>'.'HTTP版本：'.$ServerInfo->GetHttpVersion().'</li>';
$rs .= '<li>'.'网站根目录：'.$ServerInfo->GetDocumentRoot().'</li>';
$rs .= '<li>'.'最大执行时间：'.$ServerInfo->GetMaxExecutionTime().'</li>';
$rs .= '<li>'.'文件上传：'.$ServerInfo->GetServerFileUpload().'</li>';
$rs .= '<li>'.'全局变量 register_globals：'.$ServerInfo->GetRegisterGlobals().'</li>';
$rs .= '<li>'.'安全模式 safe_mode：'.$ServerInfo->GetSafeMode().'</li>';
$rs .='<li>'. '图形处理 GD Library：'.$ServerInfo->GetGdVersion().'</li>';
$rs .= '<li>'.'内存占用：'.$ServerInfo->GetMemoryUsage().'</li></ul>';
echo $rs;
?>
    </div>
  </div>
  <div  id="config_right">
    <h2 id="config_title">网站配置：</h2>
    <form method="post" action="Admin_config_check.php">
    <?php $query=sprintf('SELECT * FROM %sCONFIG',DB_TBL_PREFIX);     
	   $result=mysql_query($query,$GLOBALS['DB']);
	   $config=mysql_fetch_object($result);
	?>
      <ul>
        <li>
          <label for="username">网站标题:</label>
          <input type="text"  name="title" value="<?=$config->title;?>"/>
        </li>
        <li>
          <label for="description">网站描述:</label>
          <input type="text"  name="description" value="<?=$config->description;?>"/>
        </li>
        <li>
          <label for="keywords">网站关键词:</label>
          <input type="text"  name="keywords" value="<?=$config->keywords;?>"/>
        </li>
        <li>
          <label for="beian">备案信息:</label>
          <input type="text"  name="beian" value="<?=$config->beian;?>"/>
        </li>
        <li>
          <label for="bottom">版权信息:</label>
          <input type="text"  name="bottom" value="<?=$config->bottom;?>"/>
        </li>
        <li>
          <label for="is_closed">是否关闭:</label>
          <input name="is_closed" type="checkbox"  id="checkbox_input" value="1" <?php if($config->is_closed=="1") echo "checked=\"checked\" ";?> />
        </li>
        <li>
          <input type="submit"  id="submit_input"/>
        </li>
      </ul>
    </form>
  </div>
</div>
<?php include 'Admin_bottom.php';?>
</body>
</html>