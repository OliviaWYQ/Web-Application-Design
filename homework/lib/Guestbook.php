<?php
   include_once 'WriteLog.php';//include Log::WriteLog function
   
   class Guestbook
   {
	   private $msg_id;
	   private $fields;
	   
	   public function __construct()
	   {
		   $this->msg_id=null;
		   $this->fields=array('msg_contact'=>'',
							   'company'=>'',
							   'tel'=>'',
							   'fax'=>'',
							   'email'=>'',
							   'title'=>'',
							   'content'=>''
		   );
	   }
	   
 // override magic method to retrieve properties
    public function __get($field)
    {
        if ($field == 'msg_id')
        {
            return $this->msg_id;
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
	
	public static function GetByMsgId($id)
   {
	   
	   $query=sprintf('SELECT MSG_CONTACT,COMPANY,TEL,FAX,EMAIL,TITLE,CONTENT FROM %sGUESTBOOK WHERE MSG_ID=%d',
	   DB_TBL_PREFIX,
	   $id
	   );
	   Log::WriteLog(1,$query);
	   $result=mysql_query($query,$GLOBALS['DB']);
	   $row = mysql_fetch_assoc($result);	   
	   $m=new Guestbook();
	   $m->msg_contact=$row['MSG_CONTACT'];
	   $m->company=$row['COMPANY'];
	   $m->tel=$row['TEL'];
	   $m->fax=$row['FAX'];
	   $m->email=$row['EMAIL'];
	   $m->title=$row['TITLE'];
	   $m->content=$row['CONTENT'];	   
	   $m->msg_id=$id;
	   mysql_free_result($result);
	   return $m;
   }
   
 
    // return if email address is valid format
    public static function validateEmailAddr($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
	
	public function save()
	{
		if($this->msg_id)
		{
		   $query=sprintf('UPDATE %sGUESTBOOK SET MSG_CONTACT="%s",COMPANY="%s",TEL="%s",FAX="%s",EMAIL="%s",TITLE="%s",CONTENT="%s"'
			.'WHERE MSG_ID=%d',
			DB_TBL_PREFIX,
	        $this->msg_contact,
	        $this->company,
	        $this->tel,
			$this->fax,
	        $this->email,
	        $this->title,
	        $this->content
			);
			//-------------------------------------------------------------------
			$log=sprintf('UPDATE %sGUESTBOOK SET MSG_CONTACT="%s",COMPANY="%s",TEL="%s",FAX="%s",EMAIL="%s",TITLE="%s",CONTENT="%s"'
			.'WHERE MSG_ID=%d',
			DB_TBL_PREFIX,
	        $this->msg_contact,
	        $this->company,
	        $this->tel,
			$this->fax,
	        $this->email,
	        $this->title,
	        substr($this->content,1,50)
			);
			Log::WriteLog(3,$log);// write log record to database
			//-------------------------------------------------------------------
			mysql_query($query,$GLOBALS['DB']);
			
	    }
		else
		{
			$query=sprintf('INSERT INTO %sGUESTBOOK (MSG_CONTACT,COMPANY,TEL,FAX,EMAIL,TITLE,CONTENT)'.
			'VALUES("%s","%s","%s","%s","%s,"%s","%s")',
			DB_TBL_PREFIX,
            mysql_real_escape_string($this->msg_contact, $GLOBALS['DB']),
            mysql_real_escape_string($this->company, $GLOBALS['DB']),
			mysql_real_escape_string($this->tel, $GLOBALS['DB']),
			mysql_real_escape_string($this->fax, $GLOBALS['DB']),
			mysql_real_escape_string($this->email, $GLOBALS['DB']),
			mysql_real_escape_string($this->title, $GLOBALS['DB']),
            mysql_real_escape_string($this->content, $GLOBALS['DB'])
			);
			//-------------------------------------------------------------------
			$log=sprintf('INSERT INTO %sGUESTBOOK (MSG_CONTACT,COMPANY,TEL,FAX,EMAIL,TITLE,CONTENT)'.
			'VALUES("%s","%s","%s","%s","%s,"%s","%s")',
			DB_TBL_PREFIX,
            mysql_real_escape_string($this->msg_contact, $GLOBALS['DB']),
            mysql_real_escape_string($this->company, $GLOBALS['DB']),
			mysql_real_escape_string($this->tel, $GLOBALS['DB']),
			mysql_real_escape_string($this->fax, $GLOBALS['DB']),
			mysql_real_escape_string($this->email, $GLOBALS['DB']),
			mysql_real_escape_string($this->title, $GLOBALS['DB']),
            substr($this->content,1,50)
			);
			Log::WriteLog(3,$log);// write log record to database
			//-------------------------------------------------------------------
			mysql_query($query, $GLOBALS['DB']);
			$this->msg_id = mysql_insert_id($GLOBALS['DB']);
			
		}
    }
	public function delete()
	{
		$query=sprintf('DELETE FROM %sGUESTBOOK WHERE MSG_ID=%d',DB_TBL_PREFIX,$this->msg_id);
		mysql_query($query,$GLOBALS['DB']);
		Log::WriteLog(4,$query);
	
	}
}
   



?>