<?php
 include_once 'WriteLog.php';//include Log::WriteLog function
 
class Article
{
	private $msg_id;
	private $fields;
	public  $mtime;
	
	//initialize a Article object
	public function _construct()
	{
		$this->msg_id=null;
		$this->fields=array('category_id'=>'',
		                     'title'=>'',
							 'keywords'=>'',
							 'auther'=>'',
							 'content'=>'',
		                     'is_top'=>false,
							);
	}
   // override magic method to retrieve properties
   public function _get($fields)
   {
	   if($fields=='msg_id')
	   {
	   return $this->msg_id;
	   }
	   else
	   {
		   return $this->fields['$fields'];
	   }
	   	   
	}  
	// override magic method to set properties
	public function _set($fields,$value)
	{
		if (array_key_exists($field, $this->fields))
        {
            $this->fields[$field] = $value;
        }
		
	}
 
    // return an object populated based on the record's news id
	public static function GetByNewsId($msg_id)
	{
		$m=new Article();
		$query = sprintf('SELECT CATEGORY_ID, TITLE, KEYWORDS, AUTHER,CONTENT,IS_TOP,NEWS_TIME ' .
            'FROM %sNEWS WHERE NEWS_ID = %d',
            DB_TBL_PREFIX,
            $msg_id);
		Log::WriteLog(1,$query);// write log record to database
		$result = mysql_query($query, $GLOBALS['DB']);  // imoprt the global database connect
		if (mysql_num_rows($result))
        {
            $row = mysql_fetch_assoc($result);
            $m->category_id = $row['CATEGORY_ID'];
            $m->title = $row['TITLE'];
            $m->keywords = $row['KEYWORDS'];
            $m->auther = $row['AUTHER'];
			$m->content=$row['CONTENT'];
			$m->is_top=$row['IS_TOP'];
			$m->mtime=$row['NEWS_TIME'];
            $m->msg_id = $msg_id;
        }
        mysql_free_result($result);

        return $m;
		
	}
	 // save the article to the database
	public function save()
    {
		if($this->msg_id)
		{
			$query=sprintf('UPDATE %sNEWS SET CATEGORY_ID="%s",TITLE="%s",KEYWORDS="%s",AUTHER="%s",CONTENT="%s",IS_TOP="%d"'.'WHERE NEWS_ID=%d',
			DB_TBL_PREFIX,
			mysql_real_escape_string($this->category_id, $GLOBALS['DB']),
            mysql_real_escape_string($this->title, $GLOBALS['DB']),
            mysql_real_escape_string($this->keywords, $GLOBALS['DB']),
			mysql_real_escape_string($this->auther, $GLOBALS['DB']),
            mysql_real_escape_string($this->content, $GLOBALS['DB']),
            $this->is_top,			
            $this->msg_id);
			//-------------------------------------------------------------------
			$log=sprintf('UPDATE %sNEWS SET CATEGORY_ID="%s",TITLE="%s",KEYWORDS="%s",AUTHER="%s",CONTENT="%s",IS_TOP="%d"'.'WHERE NEWS_ID=%d',
			DB_TBL_PREFIX,
			mysql_real_escape_string($this->category_id, $GLOBALS['DB']),
            mysql_real_escape_string($this->title, $GLOBALS['DB']),
            mysql_real_escape_string($this->keywords, $GLOBALS['DB']),
			mysql_real_escape_string($this->auther, $GLOBALS['DB']),
            substr($this->content,1,50),
            $this->is_top,			
            $this->msg_id);
			Log::WriteLog(3,$log);// write log record to database
			//-------------------------------------------------------------------
			mysql_query($query, $GLOBALS['DB']);
		}
		else
		{
			$query=sprintf('INSERT INTO %sNEWS (CATEGORY_ID,TITLE,KEYWORDS,AUTHER,CONTENT,IS_TOP)'.'VALUES("%s","%s","%s","%s","%s","%d")',
			DB_TBL_PREFIX,
			mysql_real_escape_string($this->category_id, $GLOBALS['DB']),
            mysql_real_escape_string($this->title, $GLOBALS['DB']),
            mysql_real_escape_string($this->keywords, $GLOBALS['DB']),
			mysql_real_escape_string($this->auther, $GLOBALS['DB']),
            mysql_real_escape_string($this->content, $GLOBALS['DB']),
            $this->is_top);
			
			mysql_query($query, $GLOBALS['DB']);
			$this->msg_id = mysql_insert_id($GLOBALS['DB']);
			//-------------------------------------------------------------------
			$log=sprintf('INSERT INTO %sNEWS (CATEGORY_ID,TITLE,KEYWORDS,AUTHER,CONTENT,IS_TOP)'.'VALUES("%s","%s","%s","%s","%s","%d")',
			DB_TBL_PREFIX,
			mysql_real_escape_string($this->category_id, $GLOBALS['DB']),
            mysql_real_escape_string($this->title, $GLOBALS['DB']),
            mysql_real_escape_string($this->keywords, $GLOBALS['DB']),
			mysql_real_escape_string($this->auther, $GLOBALS['DB']),
            substr($this->content,1,50)."\"",
            $this->is_top);
			Log::WriteLog(3,$log);// write log record to database
			//-------------------------------------------------------------------
		}
				
	}
	//set the news display at top
	
	public function setTop()
	{
		$this->is_top=true;
		$this->save();
    }
	
	//unset the news display at top
	public function unsetTop()
	{
		$this->is_top=false;
		$this->save();
	} 
	public function delete()
	{
		$query=sprintf('DELETE FROM %sNEWS WHERE NEWS_ID="%s"',
		  DB_TBL_PREFIX,
		  $this->msg_id
		  ); 
		  Log::WriteLog(4,$query);// write log record to database
		  mysql_query($query,$GLOBALS['DB']);
    }
		
}
?>