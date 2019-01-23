<?php
  include '401.php';
  include '../lib/db.php';
  include '../lib/Page_class.php';
  include '../lib/functions.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/functions.js"></script>
</head>

<body>
<div id="main">
  <div id="product_left">
    <ul>
      <li><a href="?p=1">分类管理</a></li>
      <li><a href="?p=2">新闻管理</a></li>
    </ul>
  </div>
  <div id="product_right">
    <?php if(isset($_GET['p'])&&($_GET['p']==1))
     {
  ?>
    <form method="post" >
      <ul id="produ_category">
        <li> <span>添加大类:</span>
          <input type="text" name="add" />
          <input type="submit" value="添加大类" class="btn" onclick="form.action='Admin_news_check.php?action=1;?>';form.submit();"/>
        </li>
        <li>
          <h3>管理大类:</h3>
        </li>
        <?php
   $query=sprintf('SELECT CATEGORY_ID,PARENT_ID,NAME,DESCRIPTION FROM %sCATEGORY WHERE PARENT_ID="3"',DB_TBL_PREFIX);
   $result=mysql_query($query,$GLOBALS['DB']);
   while($row=mysql_fetch_assoc($result))
   {
?>
        <li> <span>---></span>
          <input type="text" name="<?php echo 'name'.$row['CATEGORY_ID'];?>" value="<?=$row['NAME'];?>" />
          <input type="submit" value="修改" class="btn" onclick="form.action='Admin_product_check.php?action=2&id=<?=$row['CATEGORY_ID'];?>';form.submit();"/>
          <input type="submit" value="删除" class="btn" onclick="form.action='Admin_product_check.php?action=3&id=<?=$row['CATEGORY_ID'];?>';form.submit();"/>
        </li>
        <?php
   }
   mysql_free_result($result);
   ?>
      </ul>
    </form>
    <?php
	 }else
	 {
  ?>
    <?php
	     if(isset($_GET['category'])&&($_GET['category']<>'0'))
		 {
		 $sql=sprintf('SELECT COUNT(*) FROM %sNEWS WHERE CATEGORY_ID="%d"',DB_TBL_PREFIX,mysql_escape_string($_GET['category']));
		 $r=mysql_query($sql,$GLOBALS['DB']);
         $array=mysql_fetch_array($r);
         $total=$array[0];
		 mysql_free_result($r);
		 $nowpage=isset($_GET['page'])?$_GET['page']:1;
		 $page=new page($total,'10',"page",$nowpage);//记录总数 和每页显示条数 
		 $from=$page->getOffset();
		 $to=$page->getPagesize();
	     $query=sprintf('SELECT NEWS_ID,CATEGORY_ID,TITLE,KEYWORDS,AUTHER,IS_TOP,NEWS_TIME FROM %sNEWS WHERE CATEGORY_ID="%d" ORDER BY NEWS_ID DESC  LIMIT %d,%d',
		 DB_TBL_PREFIX,
		 mysql_escape_string($_GET['category']),
		 $from,
		 $to	 	 
		 );		 
		 }
		 else
		 {
		 $sql=sprintf('SELECT COUNT(*) FROM %sNEWS',DB_TBL_PREFIX);
		 $r=mysql_query($sql,$GLOBALS['DB']);
         $array=mysql_fetch_array($r);
         $total=$array[0];
		 mysql_free_result($r);
		 $nowpage=isset($_GET['page'])?$_GET['page']:1;
		 $page=new page($total,'10',"page",$nowpage);//记录总数 和每页显示条数
		 $from=$page->getOffset();
		 $to=$page->getPagesize();
	     $query=sprintf('SELECT NEWS_ID,CATEGORY_ID,TITLE,KEYWORDS,AUTHER,IS_TOP,NEWS_TIME FROM %sNEWS ORDER BY NEWS_ID DESC LIMIT %d,%d',
		 DB_TBL_PREFIX,
		 $from,
		 $to	 	 
		 );	 
		 }
     ?>
    <ul id="product_ul_table">
      <form method="post">
        <li id="begin_li">
          <dd id="select_all">全选:
            <input   type="checkbox" onclick="selectAll(this)" />
          </dd>
          <dd id="select_box">
            <select   onchange="if(this.options[this.selectedIndex].value!=''){window.location=this.options[this.selectedIndex].value}">
              <option   value=''>分类查看</option>
              <?php $cat=mysql_query("SELECT * FROM YOVAE_CATEGORY WHERE PARENT_ID='3'",$GLOBALS['DB']);
			   while($ob=mysql_fetch_object($cat))
			   {
			?>
              <option  value='?category=<?=$ob->CATEGORY_ID;?>'>
              <?=$ob->NAME;?>
              </option>     
               <?php
			   }
            ?>
              <option   value='?category=0'>查看所有</option>
            </select>
          </dd>
          <input name="add" type="button" value="添加新闻" onclick="form.action='Admin_news_add.php?action=1';form.submit();" />
          <input name="add" type="button" value="删除选中新闻" onclick="form.action='Admin_news_check.php?action=6';form.submit();"/>
        </li>
        <li>
          <dl>
            <dd class="th_1">ID</dd>
            <dd class="th_2">类别</dd>
            <dd class="th_3">发布时间</dd>
            <dd class="th_4">作者</dd>
            <dd class="th_5">标题</dd>
            <dd class="th_6">选项</dd>
          </dl>
        </li>
        <?php $result=mysql_query($query,$GLOBALS['DB']);
	    $i=0;
	    while($obj=mysql_fetch_object($result))
		{
			$i++;
	?>
        <li>
          <dl>
            <dd class="th_1">
              <input name="pid<?=$i;?>" type="checkbox" value="<?=$obj->NEWS_ID;?>" />
            </dd>
            <dd class="th_2">
              <?=GetByCategoryId($obj->CATEGORY_ID);?>
            </dd>
            <dd class="th_3">
              <?php $time=explode(" ",$obj->NEWS_TIME);echo $time[0];?>
            </dd>
            <dd class="th_4">
              <?=$obj->AUTHER;?>
            </dd>
            <dd class="th_5"><?=cut_str($obj->TITLE,15);?></dd>
            <dd class="th_6"><a href="Admin_news_add.php?action=2&id=<?=$obj->NEWS_ID;?>">修改</a><a href="Admin_news_check.php?action=5&id=<?=$obj->NEWS_ID;?>" onclick="return confirmAct();">删除</a></dd>
          </dl>
        </li>
        <?php
      }
      ?>
        <li id="end_li">
          <?=$page->show();?>
        </li>
      </form>
    </ul>
    <?php
	 };
    ?>
  </div>
</div>
<div class="clear"></div>
<?php include 'Admin_bottom.php';?>
</body>
</html>