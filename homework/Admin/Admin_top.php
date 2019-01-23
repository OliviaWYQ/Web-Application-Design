<?php include '401.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理</title>
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="top">
  <ul>
    <li><a href="Admin_config.php" target="bottom">网站配置</a> </li>
    <li><a href="Admin_company.php" target="bottom">关于我们</a>
      <dl>
        <dd><a href="Admin_company.php?id=1" target="bottom">公司概况</a></dd>
        <dd><a href="Admin_company.php?id=2" target="bottom">资质荣誉</a></dd>
        <dd><a href="Admin_company.php?id=3" target="bottom">销售网络</a></dd>
        <dd><a href="Admin_company.php?id=4" target="bottom">公司位置</a></dd>
        <dd><a href="Admin_company.php?id=5" target="bottom">联系我们</a></dd>
      </dl>
    </li>
    <li><a href="Admin_product.php" target="bottom">产品管理</a>
      <dl>
        <dd><a href="Admin_product.php?p=1" target="bottom">管理分类</a></dd>
        
        <dd><a href="Admin_product.php?p=2" target="bottom">管理产品</a></dd>
        
      </dl>
    </li>
    <li><a href="Admin_news.php" target="bottom">新闻管理</a>
      <dl>
        <dd><a href="Admin_news.php?p=1" target="bottom">管理分类</a></dd>
        
        <dd><a href="Admin_news.php?p=2" target="bottom">管理新闻</a></dd>
      </dl>
    </li>
    <li><a href="Admin_guestbook.php" target="bottom">留言管理</a>
    </li>
    <li><a href="Admin_administrator.php" target="bottom">网站管理</a>
    <dl>
        <dd><a href="Admin_administrator.php?action=2" target="bottom">添加管理员</a></dd>
        <dd><a href="Admin_administrator.php" target="bottom">管理员控制</a></dd>
        <dd><a href="Admin_log.php" target="bottom">日志查看</a></dd>
      </dl></li>
    <li><a href="Admin_login.php?logout=1" target="_top">退出登陆</a></li>
  </ul>
</div>
</body>
</html>