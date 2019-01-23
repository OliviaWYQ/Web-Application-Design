<?php
  include_once 'WriteLog.php';//include Log::WriteLog function

  class Product  //class for manage product 
  {
	  private $product_id;
	  private $fields;
	  
	  //initalize a product category object
	 public function __construct()
	  {
		  $this->product_id=null;
		  $this->fields=array(
		  'category_id'=>'',
		  'name'=>'',
		  'number'=>'', 
		  'specification'=>'',
		  'introduction'=>'' 
		  );
		  
	  }
	  
	  // override magic method to retrieve properties
	  
	  public function __get($field)
	  {
		  if($field=='product_id')
		  {
			  return $this->product_id;
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
	  //get the record by product id
	  public static function GetByProductId($product_id)
	  {
		  $p=new Product();
		  $query=sprintf('SELECT CATEGORY_ID,NAME,NUMBER,SPECIFICATION,INTRODUCTION FROM %sPRODUCT WHERE PRODUCT_ID=%d',
		  DB_TBL_PREFIX,
		  mysql_real_escape_string($product_id)); 
		  $result=mysql_query($query,$GLOBALS['DB']);
		  Log::WriteLog(1,$query);
		  if (mysql_num_rows($result))
          {
            $row = mysql_fetch_assoc($result);
            $p->category_id = $row['CATEGORY_ID'];
            $p->name = $row['NAME'];
            $p->number = $row['NUMBER'];
			$p->specification=$row['SPECIFICATION'];
			$p->introduction=$row['INTRODUCTION'];
            $p->product_id = $product_id;
          }
		  mysql_free_result($result);
		  return $p;
		  
	  }
	  // svae product  to database
	  public function save()
	  {
		  if($this->product_id)
		  {
			  $query=sprintf('UPDATE %sPRODUCT SET CATEGORY_ID="%s",NAME="%s",NUMBER="%s",SPECIFICATION="%s",INTRODUCTION="%s"'.'WHERE PRODUCT_ID="%s"',
			  DB_TBL_PREFIX,
			  mysql_real_escape_string($this->category_id),
			  mysql_real_escape_string($this->name),
			  mysql_real_escape_string($this->number),
			  mysql_real_escape_string($this->specification),
			  mysql_real_escape_string($this->introduction),
			  $this->product_id			  		  
			  );
			 
			  mysql_query($query,$GLOBALS['DB']);
			  //-------------------------------------------------------------------
			$log=sprintf('UPDATE %sPRODUCT SET CATEGORY_ID="%s",NAME="%s",NUMBER="%s",SPECIFICATION="%s",INTRODUCTION="%s"'.'WHERE PRODUCT_ID="%s"',
			  DB_TBL_PREFIX,
			  mysql_real_escape_string($this->category_id),
			  mysql_real_escape_string($this->name),
			  mysql_real_escape_string($this->number),
			  mysql_real_escape_string($this->specification),
			  substr($this->introduction,1,50),
			  $this->product_id			  		  
			  );
			Log::WriteLog(3,$log);// write log record to database
			//-------------------------------------------------------------------
		  }
		  else
	      {
			  $query=sprintf('INSERT INTO %sPRODUCT (CATEGORY_ID,NAME,NUMBER,SPECIFICATION,INTRODUCTION)'.'VALUES("%s","%s","%s","%s","%s")',
			  DB_TBL_PREFIX,
			  mysql_real_escape_string($this->category_id),
			  mysql_real_escape_string($this->name),
			  mysql_real_escape_string($this->number),
			  mysql_real_escape_string($this->specification),
			  mysql_real_escape_string($this->introduction)	  
			  );
			 
			  mysql_query($query,$GLOBALS['DB']);
			  $this->product_id = mysql_insert_id($GLOBALS['DB']);
			//-------------------------------------------------------------------
			$log=sprintf('INSERT INTO %sPRODUCT (CATEGORY_ID,NAME,NUMBER,SPECIFICATION,INTRODUCTION)'.'VALUES("%s","%s","%s","%s","%s")',
			  DB_TBL_PREFIX,
			  mysql_real_escape_string($this->category_id),
			  mysql_real_escape_string($this->name),
			  mysql_real_escape_string($this->number),
			  mysql_real_escape_string($this->specification),
			  substr($this->introduction,1,50)	  
			  );
			Log::WriteLog(3,$log);// write log record to database
			//-------------------------------------------------------------------
		  }
		  
		  
	  
	  }
	  //delete product record from database
	  public function delete()
	  {
		  echo "<script type=\"text/javascript\">".$this->product_id."</script>";
		  $query=sprintf('DELETE FROM %sPRODUCT WHERE PRODUCT_ID="%s"',
		  DB_TBL_PREFIX,
		  $this->product_id
		  ); 
		  Log::WriteLog(4,$query);
		  mysql_query($query,$GLOBALS['DB']);
	  
	  }
	  
	  
	  
	  
  }

?>