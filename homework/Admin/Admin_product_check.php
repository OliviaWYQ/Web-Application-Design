<?php
  // include shared code
  include '401.php';
  header("Content-Type:text/html;charset=utf-8");
  include '../lib/db.php';
  include '../lib/Category.php';
  include '../lib/functions.php';
  include '../lib/Product.php';
  //-------------------------------------------------------
  
  $action=isset($_GET['action'])?intval($_GET['action']):0;
  $id=isset($_GET['id'])?intval($_GET['id']):"0";
  switch($action)
  {
	  case 0:
	  gourl("参数错误","Admin_product.php?p=1");
	  break;
	  
	  case 1:// add new category retrieve parent_id=id from Admin_product.php
	  $c=new Category();
	  $c->parent_id=$id;
	  $mark='add'.$id;
	  if($_POST[$mark]=="")
	  {
		  goback("类名不能为空");
		  exit();
	  }
	  $c->name=$_POST[$mark];
	  $c->description=$_POST[$mark];
	  $c->save();
	  gourl("添加成功","Admin_product.php?p=1");
	  break;
	  
	  case 2:// alter category retrieve category_id=id from Admin_product.php
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
	  gourl("修改成功","Admin_product.php?p=1");
	  break;
	  
	  case 3:// delete category retrieve category_id=id from Admin_product.php
	  $c=new Category();
	  $c=Category::GetByCategoryId($id);
	  $c->delete();
	  gourl("删除成功","Admin_product.php?p=1");
	  break;
	  
	  case 4:// alter product or add new product from Admin_product_add.php
	  if($_POST['name']==""||$category_id=$_POST['selectbox']=="")
	  {
		  goback("有星号的不能为空");
		  exit();
		  
	  }
	  $flag=$_GET['flag'];
	  $name=$_POST['name'];
	  $number=$_POST['number'];
	  $category_id=$_POST['selectbox'];
	  $specification=$_POST['specification'];
	  $introduction=$_POST['introduction'];
	  if($flag==1)
	  {
		  $id=$_GET['id'];
		  $p=new Product();
		  $p=Product::GetByProductId($id);
		  $p->name=$name;
		  $p->number=$number;
		  $p->category_id=$category_id;
		  $p->specification=$specification;
		  $p->introduction=$introduction;
		  $p->save();
		  gourl("修改成功","Admin_product.php?p=2");
	  }
	  else
	  {
		  $p=new Product();
		  $p->name=$name;
		  $p->number=$number;
		  $p->category_id=$category_id;
		  $p->specification=$specification;
		  $p->introduction=$introduction;
		  $p->save();
		  gourl("添加成功","Admin_product.php?p=2");
	  }
	  break;
	
	  case 5: // delete product retrieve product_id=id from Admin_product.php
	  $p=new Product();
	  $p=Product::GetByProductId($id);
	  $p->delete();
	  gourl("删除成功","Admin_product.php?p=2");
	  break;	 
	  
	  case 6://delete all selected product from database from Admin_product.php
	  
	  for($i=1;$i<10;$i++)
	  {
		  $chkbox="pid".$i;
           if(isset($_POST[$chkbox]))
		  {
			  $exe=sprintf('DELETE FROM %sPRODUCT WHERE PRODUCT_ID=%d',
			  DB_TBL_PREFIX,
			  mysql_escape_string($_POST[$chkbox])
			  );
			  mysql_query($exe);
		  }
	  
	  }
	  gourl("删除成功","Admin_product.php?p=2");
	  break; 
	  
	  default:
	  goback("参数错误");
	  break;
	  
	  
}
  
  

?>