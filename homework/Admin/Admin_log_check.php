<?php
   include '401.php';
   include '../lib/db.php';
   include_once '../lib/WriteLog.php';
   
   header("Content-Type:text/html;charset=utf-8");
   
   $id=isset($_GET['id'])?intval($_GET['id']):0;
   $l=new Log();
   $l=Log::GetById($id);
   ob_start();
 ?>
   <h5>详细信息</h5>
  <hr/>
  <p><span>用户:</span>&nbsp;<?=$l->username;?>&nbsp;<span>&nbsp;在</span>&nbsp;<?=$l->logtime;?>&nbsp;&nbsp;&nbsp;
  <?
  switch($l->action) 
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
  
  ?><span>&nbsp;数据&nbsp;</span></p>
  <hr/>
  <p><span>SQL</span></p>
  <hr/>
  <p><?=$l->content;?></p>
<?
  $r = ob_get_contents();
  ob_end_clean();
  echo $r;
?>