<?php  // include shared code
  include '401.php';
  header("Content-Type:text/html;charset=utf-8");
  include '../lib/db.php';
  include '../lib/functions.php';
  include '../lib/Page_class.php';
  include '../lib/Guestbook.php';
  //-------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="main">
<?php
   $action=isset($_GET['action'])?intval($_GET['action']):0;
   if($action=='0')
{
?>
<div id="guestbook">
<ul>
<?php
    $sql=sprintf('SELECT COUNT(*) FROM %sGUESTBOOK',DB_TBL_PREFIX);
    $r=mysql_query($sql,$GLOBALS['DB']);
    $array=mysql_fetch_array($r);
    $total=$array[0];
	mysql_free_result($r);
	$nowpage=isset($_GET['page'])?$_GET['page']:1;
	$page=new page($total,'10',"page",$nowpage);//记录总数 和每页显示条数
	$from=$page->getOffset();
	$to=$page->getPagesize();
    $query=sprintf('SELECT MSG_ID,MSG_CONTACT,COMPANY,TITLE,CONTENT,MSG_TIME FROM %sGUESTBOOK LIMIT %d,%d',DB_TBL_PREFIX,$from,$to);
	$result=mysql_query($query,$GLOBALS['DB']);
	while($ob=mysql_fetch_object($result))
	{
?>
<li>
<dl>
<dd class="g_1"><span>ID:</span><?=$ob->MSG_ID;?></dd><dd class="g_2"><span>联系人:</span><?=$ob->MSG_CONTACT;?></dd><dd class="g_3"><span>公司:</span><?=$ob->COMPANY;?></dd><dd class="g_4"><span>留言时间:</span><? $t=explode(" ",$ob->MSG_TIME);echo $t[0];?></dd><dd class="g_5"><a href="?action=1&id=<?=$ob->MSG_ID;?>">查看详细</a><a href="?action=2&id=<?=$ob->MSG_ID;?>">删除</a></dd>
</dl>
<p class="g_6"><span>内容概要:</span><?=cut_str($ob->CONTENT,200);?></p>
</li>
<?php
	}
?>
<li id="page_li"><?=$page->show();?></li>
</ul>
</div>
<?php
 }
 if($action=='1')
	{
		$id=isset($_GET['id'])?intval($_GET['id']):0;
		$gk=new Guestbook();
		$gk=Guestbook::GetByMsgId($id);
?>
<div id="guestbook">
<ul id="guestbook_detail_ul">
<li><dl><dd><span>ID:</span><?=$gk->msg_id;?></dd><dd><span>联系人:</span><?=$gk->msg_contact;?></dd><dd><span>公司:</span><?=$gk->company;?></dd></dl></li>
<li ><dl><dd><span>TEL:</span><?=$gk->tel;?></dd><dd><span>FAX:</span><?=$gk->fax;?></dd><dd><span>EMAIL:</span><?=$gk->email;?></dd></dl></li>
<li><span>标题:</span><?=$gk->title;?></li>
<li id="g_01"><span>留言内容:</span><?=$gk->content;?></li>
<li id="g_02"><a href="?action=2&id=<?=$gk->msg_id;?>">删除</a><a href="?action=0">返回</a></li>
</ul>
</div>
<?php
	}
	else if($action==2)
	{
		$id=isset($_GET['id'])?intval($_GET['id']):0;
		$msg=new Guestbook();
		$msg=Guestbook::GetByMsgId($id);
		$msg->delete();
		gourl("删除留言成功","?action=0");
		
		
	}
?>
</div>
<div class="clear"></div>
<?php include 'Admin_bottom.php';?>
</body>
</html>