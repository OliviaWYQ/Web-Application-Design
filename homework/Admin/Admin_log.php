<?php  
   include '401.php';
   include '../lib/Page_class.php';
   include '../lib/db.php';
   include '../lib/functions.php';
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
   if(!$_SESSION['super'])
   {
	   gourl("管理权限不够!","Admin_main.php");
	   exit();
   }
?>
<title></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/*                            
* ----------------------------------------------------------------------
*  Here start the Admin_log.php css style
* ----------------------------------------------------------------------
*/

#log {
	float:left;
	width:450px;
	margin-left:5%;
	padding-top:10px;
	height:500px;
}
#log ul {
	border:#3CF solid 1px;
	width:450px;
	list-style:none;
}
#log ul #log_head {
	height:20px;
	background:#F96;}
#log ul #log_head dl dd {
	font-size:12px;
	font-weight:bold;
	text-align:left;
	height:20px;
}
#log ul li {
	width:450px;
	height:25px;
	border-top:#06F solid 1px;
}
#log ul li:hover{
	background:#3CC;}
#log ul li dl dd {
	float:left;
	height:25px;
	font-size:10px;
    text-align:left;
}
#log ul li dl .log_id {
	width:50px;
}
#log ul li dl .log_op {
	width:50px;
}
#log ul li dl .log_user {
	width:80px;
}
#log ul li dl .log_sql {
	width:170px;
}
#log ul li dl .log_time {
 100px;
}
#log ul #log_end{
	text-align:center;}
#log_detail{
	float:left;
	margin-left:20px;;
	margin-top:20px;
	padding:10px 5px;;
	width:390px;
	height:200px;
	border:#008 solid 1px;
	color:#000;}
#log_detail p{
	width:390px;
	}
#log_detail p span{
	color:#30C;
	font-weight:bold;}
#log_detail h5{
	text-align:center;
	font-size:14px;
	color:#000;}
</style>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript">
function doRequest(id)
{
	window.httpObj=createXMLHTTPObject();
	var url='Admin_log_check.php?id='+id+'&nocache='+(new Date()).getTime();
	window.httpObj.open('GET',url,true);
	
	window.httpObj.onreadystatechange=function()
	{
		if(window.httpObj.readyState==4&&window.httpObj.responseText)
		{
		// do what you want to do here	
		document.getElementById('log_detail').innerHTML=window.httpObj.responseText;
					
		}
	}
	window.httpObj.send(null);
}
function setnull()
{
	document.getElementById('log_detail').innerHTML="<h5>移动鼠标到响应记录显示详细信息</h5>";
}

</script>
</head>
<body>
<div id="main">
  <div id="log">
    <ul>
      <li id="log_head">
        <dl>
          <dd class="log_id">ID</dd>
          <dd class="log_user">用户</dd>
          <dd class="log_op">操作</dd>
          <dd class="log_sql">记录</dd>
          <dd class="log_time">时间</dd>
        </dl>
      </li>
      <?php
	     $sql=sprintf('SELECT COUNT(*) FROM %sLOG',DB_TBL_PREFIX);
		 $r=mysql_query($sql,$GLOBALS['DB']);
         $array=mysql_fetch_array($r);
         $total=$array[0];
		 mysql_free_result($r);
		 $nowpage=isset($_GET['page'])?$_GET['page']:1;
		 $page=new page($total,'20',"page",$nowpage);//记录总数 和每页显示条数 
		 $from=$page->getOffset();
		 $to=$page->getPagesize();
	     $query=sprintf('SELECT * FROM %sLOG  ORDER BY ID DESC  LIMIT %d,%d',
		 DB_TBL_PREFIX,
		 $from,
		 $to);
		 $result=mysql_query($query,$GLOBALS['DB']);
		 while($ob=mysql_fetch_object($result))
		 {
      ?>
      <li onmouseover="doRequest(<?=$ob->ID;?>)" onmouseout="setnull()">
        <dl>
          <dd class="log_id"><?=$ob->ID;?></dd>
          <dd class="log_user"><?=$ob->USERNAME;?></dd>
          <dd class="log_op">
		  <?php 
		  switch($ob->ACTION) 
		  {
			   case 0: echo "不法用户";break;
			  case 1: echo "查看";   break;
			  case 2: echo "插入";break;
			  case 3: echo "修改";break;
			  case 4: echo "删除";break;
			  case 5: echo "修改配置";break;
			  case 6: echo "成功登陆";break;
			  case 7: echo "登录失败";break;
			  default: echo "未知操作";break;
			
		  }
		  
		  ?></dd>
          <dd class="log_sql"><?php $str=substr($ob->CONTENT,0,20);$str=$str."...";echo $str;?></dd>
          <dd class="log_time"><?php $t=explode (" ",$ob->LOGTIME);$t[0]=str_replace("-","/",$t[0]);echo $t[0];?></dd>
        </dl>
      </li>
      <?php
		 }
      ?>
      <li id="log_end"><?php echo $page->show();?></li>
    </ul>
  </div>
  <div id="log_detail">
  </div>
</div>
<div class="clear"></div>
<?php include 'Admin_bottom.php';?>
</body>
</html>