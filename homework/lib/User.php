<?php
  
  include_once 'WriteLog.php';//include Log::WriteLog function

class User
{
    private $uid;     // user id
    private $fields;  // other record fields

    // initialize a User object
    public function __construct()
    {
        $this->uid = null;
        $this->fields = array('username' => '',
                              'userpassword' => '',
                              'email_Addr' => '',
							  'isSuper'=>false,
                              'isActive' => true);
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

    // return if username is valid format
    public static function validateUsername($username)
    {
        return preg_match('/^[A-Z0-9]{2,20}$/i', $username);
    }
    
    // return if email address is valid format
    public static function validateEmailAddr($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    // return an object populated based on the record's user id
    public static function getById($uid)
    {
        $u = new User();

        $query = sprintf('SELECT USERNAME,USERPASSWORD, EMAIL_ADDR, IS_SUPER,IS_ACTIVE ' .
            'FROM %sUSER WHERE USER_ID = %d',
            DB_TBL_PREFIX,
            $uid);
		Log::WriteLog(1,$query);// write log record to database
        $result = mysql_query($query, $GLOBALS['DB']);

        if (mysql_num_rows($result))
        {
            $row = mysql_fetch_assoc($result);
            $u->username = $row['USERNAME'];
            $u->userpassword = $row['USERPASSWORD'];
            $u->email_Addr = $row['EMAIL_ADDR'];
			$u->isSuper=$row['IS_SUPER'];
            $u->isActive = $row['IS_ACTIVE'];
            $u->uid = $uid;
        }
        mysql_free_result($result);

        return $u;
    }

    // return an object populated based on the record's username
    public static function getByUsername($username)
    {
        $u = new User();
        $query = sprintf('SELECT USER_ID, USERPASSWORD, EMAIL_ADDR,IS_SUPER, IS_ACTIVE FROM %sUSER WHERE USERNAME = "%s"',
         DB_TBL_PREFIX,
         mysql_real_escape_string($username, $GLOBALS['DB']));
        $result = mysql_query($query, $GLOBALS['DB']);
        
        if (mysql_num_rows($result))
        {
            $row = mysql_fetch_assoc($result);
            $u->username = $username;
            $u->userpassword = $row['USERPASSWORD'];
            $u->email_Addr = $row['EMAIL_ADDR'];
			$u->isSuper = $row['IS_SUPER'];
            $u->isActive = $row['IS_ACTIVE'];
            $u->uid = $row['USER_ID'];
			
        }

        mysql_free_result($result);
        return $u;
    }
	

    // save the record to the database
    public function save()
    {
        if ($this->uid)
        {
            $query = sprintf('UPDATE %sUSER SET USERNAME = "%s", ' .
                'USERPASSWORD = "%s", EMAIL_ADDR = "%s", IS_SUPER = %d,IS_ACTIVE = %d ' .
                'WHERE USER_ID = %d',
                DB_TBL_PREFIX,
                mysql_real_escape_string($this->username, $GLOBALS['DB']),
                ($this->userpassword),
                mysql_real_escape_string($this->email_Addr, $GLOBALS['DB']),
				$this->isSuper,
                $this->isActive,
                $this->uid);
				Log::WriteLog(3,$query);// write log record to database
				
            mysql_query($query, $GLOBALS['DB']);
        }
        else
        {
            $query = sprintf('INSERT INTO %sUSER (USERNAME, USERPASSWORD, ' .
                'EMAIL_ADDR,IS_SUPER, IS_ACTIVE) VALUES ("%s", "%s", "%s", %d,%d)',
                DB_TBL_PREFIX,
                mysql_real_escape_string($this->username, $GLOBALS['DB']),
                sha1($this->userpassword),
                mysql_real_escape_string($this->email_Addr, $GLOBALS['DB']),
				$this->isSuper,
                $this->isActive);
				
				Log::WriteLog(2,$query);// write log record to database
				
            mysql_query($query, $GLOBALS['DB']);

            $this->uid = mysql_insert_id($GLOBALS['DB']);
        }
    }

    // set the record as inactive and return an activation token
    public function setInactive()
    {
        $this->isActive = false;
        $this->save(); // make sure the record is saved
    }

    // set the user active
    public function setActive()
    {
            $this->isActive = true;
            $this->save();
            return true;
    }
	  public function setSuper()
    {
        $this->isSuper = true;
        $this->save(); // make sure the record is saved
    }

    // set the user active
    public function unsetSuper()
    {
            $this->isSuper = false;
            $this->save();
            return true;
    }
	public function delete()
	{
		 $query=sprintf('DELETE FROM %sUSER WHERE USER_ID="%s"',
		  DB_TBL_PREFIX,
		  $this->uid
		  ); 
		  Log::WriteLog(4,$query);// write log record to database
		  mysql_query($query,$GLOBALS['DB']);
	  
    }
	
}
?>
