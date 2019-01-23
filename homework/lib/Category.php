<?php
  include_once 'WriteLog.php';//include Log::WriteLog function
  class Category  //class for manage product class
  {
	  private $category_id;
	  private $fields;
	  
	  //initalize a product category object
	 public function __construct()
	  {
		  $this->category_id=null;
		  $this->fields=array(
		  'parent_id'=>'',
		  'name'=>'',
		  'description'=>'',  
		  );
		  
	  }
	  
	  // override magic method to retrieve properties
	  
	  public function __get($field)
	  {
		  if($field=='category_id')
		  {
			  return $this->category_id;
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
	  //get the record by category id
	  public static function GetByCategoryId($category_id)
	  {
		  $c=new Category();
		  $query=sprintf('SELECT PARENT_ID,NAME,DESCRIPTION FROM %sCATEGORY WHERE CATEGORY_ID=%s',
		  DB_TBL_PREFIX,
		  mysql_real_escape_string($category_id));
		  $result=mysql_query($query,$GLOBALS['DB']);
		  Log::WriteLog(1,$query);
		  if (mysql_num_rows($result))
          {
            $row = mysql_fetch_assoc($result);
            $c->parent_id = $row['PARENT_ID'];
            $c->name = $row['NAME'];
            $c->description = $row['DESCRIPTION'];
            $c->category_id = $category_id;
          }
		  mysql_free_result($result);
		  return $c;
		  
	  }
	  // svae product category to database
	  public function save()
	  {
		  if($this->category_id)
		  {
			  $query=sprintf('UPDATE %sCATEGORY SET PARENT_ID="%s",NAME="%s",DESCRIPTION="%s"'.'WHERE CATEGORY_ID="%s"',
			  DB_TBL_PREFIX,
			  mysql_real_escape_string($this->parent_id),
			  mysql_real_escape_string($this->name),
			  mysql_real_escape_string($this->description),
			  $this->category_id			  		  
			  );
			  Log::WriteLog(3,$query);
			  mysql_query($query,$GLOBALS['DB']);
			  
		  }
		  else
	      {
			  $query=sprintf('INSERT INTO %sCATEGORY (PARENT_ID,NAME,DESCRIPTION)'.'VALUES("%s","%s","%s")',
			  DB_TBL_PREFIX,
			  mysql_real_escape_string($this->parent_id),
			  mysql_real_escape_string($this->name),
			  mysql_real_escape_string($this->description)		  
			  );
			  Log::WriteLog(2,$query);
			  mysql_query($query,$GLOBALS['DB']);
			  $this->category_id = mysql_insert_id($GLOBALS['DB']);
			  
		  }
		  
		  
	  
	  }
	  //delete product record from database
	  public function delete()
	  {
		 
		  $query=sprintf('DELETE FROM %sCATEGORY WHERE CATEGORY_ID="%s" OR PARENT_ID="%s"',
		  DB_TBL_PREFIX,
		  $this->category_id,
		  $this->category_id
		  ); 
		  Log::WriteLog(4,$query);
		  mysql_query($query,$GLOBALS['DB']);
	  
	  }
	  
	  
	  
	  
  }

?>