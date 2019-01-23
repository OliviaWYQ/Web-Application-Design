<?php
	
// database connection and schema constants
define('DB_HOST', '127.0.0.1:3306');//数据库连接地址
define('DB_USER', 'root');//数据库用户名
define('DB_PASSWORD', ''); //数据库密码
define('DB_SCHEMA', 'mydata');//数据库名
define('DB_TBL_PREFIX', 'mydata_');//数据表前缀

// establish a connection to the database server
if (!$GLOBALS['DB'] = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD))
{
    die('Error: Unable to connect to database server.');
}
if (!mysql_select_db(DB_SCHEMA, $GLOBALS['DB']))
{
    mysql_close($GLOBALS['DB']);
    die('Error: Unable to select database schema.');
}
mysql_query("set character set 'utf8'");//解决读库乱码问题
mysql_query("set names 'utf8'");//解决写库乱码问题

?>
