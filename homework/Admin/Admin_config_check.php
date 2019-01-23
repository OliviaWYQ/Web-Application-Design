<?php
  include '401.php';
  header("Content-Type: text/html;charset=utf-8");
  include '../lib/db.php';
  include '../lib/functions.php';
  include '../lib/WriteLog.php';
  
  $title=$_POST['title'];
  $description=$_POST['description'];
  $keywords=$_POST['keywords'];
  $beian=$_POST['beian'];
  $bottom=$_POST['bottom'];
  $is_closed=isset($_POST['is_closed'])?$_POST['is_closed']:0;
  $query=sprintf('UPDATE %sCONFIG SET TITLE="%s",DESCRIPTION="%s",KEYWORDS="%s",BEIAN="%s",BOTTOM="%s",IS_CLOSED=%d',
	  DB_TBL_PREFIX,
	  mysql_escape_string($title),
	  mysql_escape_string($description),
	  mysql_escape_string($keywords),
	  mysql_escape_string($beian),
	  mysql_escape_string($bottom),
	  $is_closed
	  );
	Log::WriteLog(5,$query);
 if(mysql_query($query,$GLOBALS['DB']))
	  {
		  goback("修改成功");
	  }
  else
	  { 
	      gourl("修改失败","Admin_config.php");
	  }
	exit();

?>