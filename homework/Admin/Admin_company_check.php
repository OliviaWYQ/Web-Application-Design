<?php
  include '401.php';
  header("Content-Type: text/html;charset=utf-8"); 
  include '../lib/db.php';
  include '../lib/functions.php';
  include '../lib/WriteLog.php';
  
  $msg_id=isset($_GET['id'])?$_GET['id']:0;//receive news_id
  $content=$_POST['content'];
  $query=sprintf('UPDATE %sCOMPANY SET CONTENT="%s" WHERE ID=%d',DB_TBL_PREFIX,mysql_escape_string($content),mysql_escape_string($msg_id));
  Log::WriteLog(3,$query);
  $result=mysql_query($query,$GLOBALS['DB']);
  if($result)
  {
  mysql_free_result($result);  
  goback("修改成功");
  }
  else
  {
  mysql_free_result($result);  
  goback("修改失败");
  }
  exit;
?>