<?php
   class Log
   {
	 private $id;
	 private $fields;
	 
	  // initialize a User object
    public function __construct()
    {
        $this->id = null;
        $this->fields = array('action' => '',
                              'username' => '',
                              'content' => '',
							  'logtime'=>''
							  );
    }

    // override magic method to retrieve properties
    public function __get($field)
    {
        if ($field == 'uid')
        {
            return $this->uid;
        }
        else 
        {
            return $this->fields[$field];
        }
    }

    // override magic method to set properties
    public function __set($field, $value)
    {
        if (array_key_exists($field, $this->fields))
        {
            $this->fields[$field] = $value;
        }
    }
	
	   
    public static function WriteLog($action=0,$sql)
	{
		/*
     	*action 的值代表操作类型
	    *0     未授权访问
	    *1     查看数据
	    *2     插入数据
	    *3     修改数据
	    *4     删除数据
	    *5     修改网站配置
	    *6     用户登陆成功
	    *7     用户登陆失败
	    */
	    $op=isset($_SESSION['username'])?$_SESSION['username']:"unknow";
		$lg=sprintf('INSERT INTO %sLOG(ACTION,USERNAME,CONTENT) VALUES(%d,"%s","%s")',DB_TBL_PREFIX,$action,$op,mysql_real_escape_string($sql));
     	mysql_query($lg,$GLOBALS['DB']);	
    }
	public static function GetById($id)
	{
		$l=new Log();
		$query=sprintf('SELECT * FROM YOVAE_LOG WHERE ID=%d',mysql_real_escape_string($id));
		$result=mysql_query($query,$GLOBALS['DB']);
		 if (mysql_num_rows($result))
		 {
			 $row = mysql_fetch_assoc($result);
			 $l->id=$row['ID'];
			 $l->action=$row['ACTION'];
			 $l->username=$row['USERNAME'];
			 $l->content=$row['CONTENT'];
			 $l->logtime=$row['LOGTIME'];
		 }
		 mysql_free_result($result);
		 return $l;
		
	}
   }
?>