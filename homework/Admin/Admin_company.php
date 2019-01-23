<?php
  include '401.php';
  include '../lib/db.php';
  include '../lib/Article.php';
  include '../lib/Category.php';
  include_once '../lib/WriteLog.php';
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<script charset="utf-8" src="../editor/kindeditor.js"></script>
<script>
        KE.show({
                id : 'your_editor_id',
				resizeMode : 1
				
        });
</script>
</head>
<body>
<div id="main">
  <div id="company_left">
    <ul>
      <li><a href="?id=1" target="bottom">公司概况</a></li>
      <li><a href="?id=2" target="bottom">资质荣誉</a></li>
      <li><a href="?id=3" target="bottom">销售网络</a></li>
      <li><a href="?id=4" target="bottom">公司位置</a></li>
      <li><a href="?id=5" target="bottom">联系我们</a></li>
    </ul>
  </div>
  <?php
     $msg_id=isset($_GET['id'])?$_GET['id']:0;
	 if($msg_id)
	 {
	 $query=sprintf('SELECT * FROM %sCOMPANY WHERE ID=%d',DB_TBL_PREFIX,mysql_escape_string($msg_id));
	 $result=mysql_query($query,$GLOBALS['DB']);
	 $m=mysql_fetch_object($result);	
	 $c=Category::GetByCategoryId($m->CATEGORY_ID);
?>
	<div id="company_right">
    <h2><?=$c->name;?></h2>
    <form method="post" action="Admin_company_check.php?id=<?=$msg_id?>">
    <div id="textarea_input">
    <textarea id="your_editor_id" name="content" cols="100" rows="8" style="width:500px;height:400px;"><?=$m->CONTENT;?></textarea>
    </div >
    <input type="submit"  id="submit_input2"/>
    </form>
  </div>
<?php
	}
	else
	{
?>
   <div id="company_right"><h2>关于公司</h2></div>
<?php
	}
?>  
</div>
<?php include 'Admin_bottom.php';?>
</body>
</html>