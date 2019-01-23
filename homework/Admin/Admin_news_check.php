<?php
  // include shared code
  include '401.php';
  header("Content-Type:text/html;charset=utf-8");
  include '../lib/db.php';
  include '../lib/Category.php';
  include '../lib/functions.php';
  include '../lib/Article.php';
  //-------------------------------------------------------
  $action=isset($_GET['action'])?intval($_GET['action']):0;
  $id=isset($_GET['id'])?intval($_GET['id']):"error";
  
  switch($action)
  {
	  case 0:
	  gourl("参数错误","Admin_product.php?page=1");
	  break;
	  
	  case 1:// add new category retrieve parent_id=id from Admin_news.php
	  if($_POST['add']=="")
	  {
		  goback("类名不能为空");
		  exit();
	  }
	  $c=new Category();
	  $c->parent_id=3;
	  $c->name=$_POST['add'];
	  $c->description=$_POST['add'];
	  $c->save();
	  gourl("添加成功","Admin_news.php?p=1");
	  break;
	  
	  case 2:// alter category retrieve category_id=id from Admin_news.php
	  $c=new Category();
	  $c=Category::GetByCategoryId($id);
	  $mark='name'.$id;
	  if($_POST[$mark]=="")
	  {
		  goback("类名不能为空");
		  exit();
	  }
	  $c->name=$_POST[$mark];
	  $c->save();
	  gourl("修改成功","Admin_news.php?p=1");
	  break;
	  
	  case 3:// delete category retrieve category_id=id from Admin_news.php
	  $c=new Category();
	  $c=Category::GetByCategoryId($id);
	  $c->delete();
	  gourl("删除成功","Admin_news.php?page=1");
	  break;
	  
	  case 4:// alter product or add news from Admin_product_add.php
	  if($_POST['title']==""||$_POST['selectbox']=="")
	  {
		  goback("*号的为必填");
		  exit();
	  }
	  $flag=$_GET['flag'];
	  $title=$_POST['title'];
	  $keywords=$_POST['keywords'];
	  $category_id=$_POST['selectbox'];
	  $auther=$_POST['auther'];
	  $content=$_POST['content'];
	  if($flag==1)
	  {
		  $id=$_GET['id'];
		  $p=new Article();
		  $p=Article::GetByNewsId($id);
		  $p->title=$title;
		  $p->keywords=$keywords;
		  $p->category_id=$category_id;
		  $p->auther=$auther;
		  $p->content=$content;
		  $p->save();
		  gourl("修改成功","Admin_news.php?p=2");
	  }
	  else
	  {
		  $p=new Article();
		  $p->name=$name;
		  $p->title=$title;
		  $p->keywords=$keywords;
		  $p->category_id=$category_id;
		  $p->auther=$auther;
		  $p->content=$content;
		  $p->save();
		  gourl("添加成功","Admin_news.php?p=2");
	  }
	  break;
	
	  case 5: // delete news retrieve product_id=id from Admin_news.php
	  $n=new Article();
	  $n=Article::GetByNewsId($id);
	  $n->delete();
	  gourl("删除成功","Admin_news.php?p=2");
	  break;	 
	  
	  case 6://delete all selected news from database from Admin_news.php
	  
	  for($i=1;$i<10;$i++)
	  {
		  $chkbox="pid".$i;
           if(isset($_POST[$chkbox]))
		  {
			  $exe=sprintf('DELETE FROM %sNEWS WHERE NEWS_ID=%d',
			  DB_TBL_PREFIX,
			  mysql_escape_string($_POST[$chkbox])
			  );
			  mysql_query($exe);
		  }
	  
	  }
	  gourl("删除成功","Admin_news.php?p=2");
	  break; 
	  
	  default:
	  goback("参数错误");
	  break;
	  
	  
}


?>