<?php
  // include shared code
  include '401.php';
  header("Content-Type:text/html;charset=utf-8");
  include '../lib/db.php';
  include '../lib/Category.php';
  include '../lib/functions.php';
  include '../lib/Article.php';
  //-------------------------------------------------------
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
  <div id="product_add">
    <?php
       $action=isset($_GET['action'])?intval($_GET['action']):0;
	   $n=new Article();
	   if($action==1)
	   {
		   $flag=false;
	   }
	   else if($action==2)
	   {
		   $flag=true;
		   $id=isset($_GET['id'])?intval($_GET['id']):0;
		   $n=Article::GetByNewsId($id);
	   }
	   else
	   {
		   goback("error!---参数错误");
	   }
   ?>
    <ul>
      <form method="post">
        <li>
          <label for="title">新闻标题:</label>
          <input name="title" type="text" value="<?=$n->title;?>" />*
        </li>
        <li id="li_3">
          <label for="auther">编者作者:</label>
          <input name="auther" type="text" class="li_2" value="<?=$n->auther;?>"/>
          <label for="category">新闻类别:</label>
          <select  name="selectbox">
            <option   value='<?php if($flag){echo $n->category_id;}else {echo " ";}?>'>
            <?php if($flag){ $buf=Category::GetByCategoryId($n->category_id);echo $buf->name;}else{ echo "选择类别";} ?>
            </option>
            <?php $cat=mysql_query("SELECT * FROM YOVAE_CATEGORY WHERE PARENT_ID='3'",$GLOBALS['DB']);
			   while($ob=mysql_fetch_object($cat))
			   {
			?>
            <option  value='<?=$ob->CATEGORY_ID;?>'>
            <?=$ob->NAME;?>
            </option>
            <?php
			   }
            ?>
          </select>*
        </li>
        <li>
          <label for="">新闻描述:</label>
          <input name="keywords" type="text"  value="<?=$n->keywords;?>"/>
        </li>
        <li id="li_4">
          <label for="content">新闻内容:</label>
        </li>
        <li id="li_5">
          <textarea id="your_editor_id" name="content" cols="100" rows="8" style="width:500px;height:400px;"><?=$n->content;?>
</textarea>
        </li>
        <li id="li_6">
          <input type="submit" value="提交" class="product_btn" onclick="form.action='Admin_news_check.php?action=4&flag=<?php if($flag){echo "1";}else{echo "0";}?>&id=<?=$id;?>';form.submit();"/>
          <input type="reset" value="重写"  class="product_btn"/>
        </li>
      </form>
    </ul>
  </div>
</div>
<?php include 'Admin_bottom.php';?>
</body>
</html>