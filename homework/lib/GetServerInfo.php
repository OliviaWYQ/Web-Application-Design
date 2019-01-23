<?php
/*
   get server information class
*/
class ServerInfo
{//class begin

    /**
     +----------------------------------------------------------
     * get server time
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetServerTime()
    {
        return date('Y-m-d　H:i:s');
    }

    /**
     +----------------------------------------------------------
     * Interpretation engine for the server
     * example：Apache/2.2.8 (Win32) PHP/5.2.6
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetServerSoftwares()
    {
        return $_SERVER['SERVER_SOFTWARE'];
    }

    /**
     +----------------------------------------------------------
     * get the PHP Version
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetPhpVersion()
    {
        return PHP_VERSION;
    }

    /**
     +----------------------------------------------------------
     * get Mysql version
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetMysqlVersion()
    {
        $con = mysql_connect("localhost", "root", "12345");
        return mysql_get_server_info($con);
    }

    /**
     +----------------------------------------------------------
     * get Http Version
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetHttpVersion()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    /**
     +----------------------------------------------------------
     * get the website root
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetDocumentRoot()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     +----------------------------------------------------------
     * The maximum execution time for PHP scripts
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetMaxExecutionTime()
    {
        return ini_get('max_execution_time').' Seconds';
    }

    /**
     +----------------------------------------------------------
     * Get the Max size of the server allows file uploads
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetServerFileUpload()
    {
        if (@ini_get('file_uploads')) {
            return '允许 '.ini_get('upload_max_filesize');
        } else {
            return '<font color="red">禁止</font>';
        }
    }

    /**
     +----------------------------------------------------------
     *Get information on the global variable settings for register_globals On / Off
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetRegisterGlobals()
    {
        return $this->GetPhpCfg('register_globals');
    }

    /**
     +----------------------------------------------------------
     * Get information about Safe Mode safe_mode setting On / Off
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetSafeMode()
    {
        return $this->GetPhpCfg('safe_mode');
    }

    /**
     +----------------------------------------------------------
     * 获取Gd库的版本号
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetGdVersion()
    {
        if(function_exists('gd_info')){
            $GDArray = gd_info();
            $gd_version_number = $GDArray['GD Version'] ? '版本：'.$GDArray['GD Version'] : '不支持';
        }else{
            $gd_version_number = '不支持';
        }
        return $gd_version_number;
    }

    /**
     +----------------------------------------------------------
     * 获取内存占用率
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function GetMemoryUsage()
    {
        return $this->ConversionDataUnit(memory_get_usage());
    }

    /**
     +----------------------------------------------------------
     * 对数据单位 (字节)进行换算 Data units (bytes) for conversion
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    private function ConversionDataUnit($size)
    {
        $kb = 1024;       // Kilobyte
        $mb = 1024 * $kb; // Megabyte
        $gb = 1024 * $mb; // Gigabyte
        $tb = 1024 * $gb; // Terabyte
        //round() 对浮点数进行四舍五入
        if($size < $kb) {
            return $size.' Byte';
        }
        else if($size < $mb) {
            return round($size/$kb,2).' KB';
        }
        else if($size < $gb) {
            return round($size/$mb,2).' MB';
        }
        else if($size < $tb) {
            return round($size/$gb,2).' GB';
        }
        else {
            return round($size/$tb,2).' TB';
        }
    }

    /**
     +----------------------------------------------------------
     * 获取PHP配置文件 (php.ini)的值
	   Get PHP configuration file (php.ini) value
     +----------------------------------------------------------
     * @param string $val 值
     * @access private
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    private function GetPhpCfg($val)
    {
        switch($result = get_cfg_var($val)) {
        case 0:
            return '关闭';
            break;
        case 1:
            return '打开';
            break;
        default:
            return $result;
            break;
        }
    }

}//class end

?>