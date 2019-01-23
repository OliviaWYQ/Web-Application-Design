<?php  // include shared code
  include '401.php';
  include '../lib/db.php';
  include '../lib/functions.php';
  include '../lib/Page_class.php';
  include '../lib/User.php';
  //-------------------------------------------------------
?>

<?php
   if(!$_SESSION['super'])
   {
	   gourl("管理权限不够!","Admin_main.php");
	   exit();
   }
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
  <?php
   $action=isset($_GET['action'])?intval($_GET['action']):1;
   if($action==1)
   {
  ?>
  <div id="admin">
    <?php
         $sql=sprintf('SELECT COUNT(*) FROM %sUSER',DB_TBL_PREFIX);
		 $r=mysql_query($sql,$GLOBALS['DB']);
         $array=mysql_fetch_array($r);
         $total=$array[0];
		 mysql_free_result($r);
		 $nowpage=isset($_GET['page'])?$_GET['page']:1;
		 $page=new page($total,'15',"page",$nowpage);//记录总数 和每页显示条数
		 $from=$page->getOffset();
		 $to=$page->getPagesize();
         $query=sprintf('SELECT USER_ID,USERNAME,USERPASSWORD,EMAIL_ADDR,IS_SUPER,IS_ACTIVE FROM %sUSER LIMIT %d,%d',DB_TBL_PREFIX,$from,$to);
	     $result=mysql_query($query,$GLOBALS['DB']);
  ?>
    <div id="admin_add"><a href="?action=2">添加管理员</a></div>
    <ul>
      <li>
        <dl id="admin_th">
          <dd id="admin_id"><span >ID:</span></dd>
          <dd><span>用户名:</span></dd>
          <dd id="admin_email"><span>Email:</span></dd>
          <dd id="admin_static"><span>状态:</span></dd>
          <dd id="admin_op">选项</dd>
        </dl>
      </li>
      <?php while($ob=mysql_fetch_object($result)){ ?>
      <li>
        <dl>
          <dd id="admin_id">
            <?=$ob->USER_ID;?>
          </dd>
          <dd>
            <?=$ob->USERNAME;?>
          </dd>
          <dd id="admin_email">
            <?=$ob->EMAIL_ADDR;?>
          </dd>
          <dd id="admin_static">
            <?php if($ob->IS_SUPER){echo "超级管理员";}else{echo "普通管理员";}?>
            ->
            <?php if($ob->IS_ACTIVE){echo "已激活";}else{echo "未激活";} ?>
          </dd>
          <dd id="admin_op"><a href="?action=2&id=<?=$ob->USER_ID;?>">修改</a><a href="?action=3&id=<?=$ob->USER_ID;?>" onclick="return confirmAct();">删除</a></dd>
        </dl>
      </li>
      <?php
	  }
      ?>
    </ul>
  </div>
  <?php
   }
   else if($action==2)
   {
  ?>
  <div id="admin">
    <?php
       $id=isset($_GET['id'])?intval($_GET['id']):0;
	   $u=new User();
	   $u=User::getById($id);
   ?>
    <form method="post" action="?action=4&id=<?=$id;?>">
      <ol>
        <li><span>用户名:</span>
          <input type="text" name="username" value="<?=$u->username;?>" />
          </li>
        <li><span>密码:</span>
          <input type="text" name="password" value="" />
          </li>
        <?php if($id){?>
        <li><span>原密码:</span>
          <?=$u->userpassword;?>
        </li>
        <?php } ?>
        <li><span>Email:</span>
          <input type="text" name="email" value="<?=$u->email_Addr;?>" />
        </li>
        <li><span>权限:</span>
          <select name="super">
            <?php if($u->isSuper) echo "<option   value='1'>超级管理员</option><option   value='0'>普通管理员</option>";else echo "<option   value='0'>普通管理员</option><option   value='1'>超级管理员</option>";?>
          </select>
          *默认普通管理员</li>
        <li><span>激活状态:</span>
          <input name="active" type="checkbox" class="active" value="1" <?php if($u->isActive==0) echo "";else echo "checked=\"checked\"";?>/>
          *默认激活</li>
        <li id="btn_li">
          <input name="提交" type="submit" value="提交" class="btn" />
          <input name="重置" type="reset" value="重置" class="btn" />
        </li>
      </ol>
    </form>
  </div>
  <?php
   }else if($action==3)
   {
	   $id=isset($_GET['id'])?intval($_GET['id']):0;
	   $u=new User();
	   $u=User::getById($id);
	   $u->delete();
	   gourl("删除成功","Admin_administrator.php");
	   
   }
   else if($action==4)
   {
	   $id=isset($_GET['id'])?intval($_GET['id']):0;
	   $u=new User();
	   if($id)
	   {	     
	     $u=User::getById($id);
		 $vname=User::validateUsername($_POST['username']);
		 if($vname)
		 $u->username=$_POST['username'];
		 else
		 {
		 goback("用户名格式错误");
		 exit();
		 }
		 if($_POST['password']=="")
		  {
		 goback("密码不能为空");
		 exit();
		 }
         $u->userpassword = $_POST['password'];
		 
		 $vmail=User::validateEmailAddr($_POST['email']);
		 if($vmail)
		 $u->email_Addr=$_POST['email'];
		 else
		 $u->email_Addr="";
	     $u->isSuper = $_POST['super'];
         $u->isActive = isset($_POST['active'])?$_POST['active']:0;
		 $u->save();
		 gourl("修改成功","Admin_administrator.php");
	   }
	   else
	   {
		 if($_POST['password']==""||$_POST['username']=="")
		  {
		 goback("用户名或密码不能为空");
		 exit();
		 }
		 $user=User::getByUsername($_POST['username']);
		 if($user->uid)
		 {
			 goback("用户已经存在");
			 $user=null;
		     exit();
		 }
		 $u->username = isset($_POST['username']);  
		 
		 $u->userpassword = $_POST['password'];
         $u->email_Addr = $_POST['email'];
	     $u->isSuper = $_POST['super'];
         $u->isActive = isset($_POST['active'])?$_POST['active']:0;
		 $u->save();
		 gourl("添加成功","Admin_administrator.php");
	   }
   }
  ?>
</div>
<?php include 'Admin_bottom.php';?>
</body>
</html>