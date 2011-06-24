<?php

class Db
{
    private $_db_config = array(
    							'host' => '127.0.0.1', 
    							'user' => 'root', 
                                'psw' => '12345'
    );

    private static $_instance = null;

    private $_db_conn = null;

    private $_now_db = '';
    
    public static function gI ()
    {
        if (null == self::$_instance)
        {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    private function __construct ()
    {
        $this->_db_conn = mysql_connect($this->_db_config['host'], $this->_db_config['user'], $this->_db_config['psw']);
        
        mysql_query("SET NAMES utf8");
    }

    public function __destruct ()
    {
        if (null != $this->_db_conn)
        {
            mysql_close($this->_db_conn);
            $this->_db_conn = null;
            self::$_instance = null;
        }
    }

    //change to another db
    public function sT ($dbName)
    {
        mysql_select_db($dbName);
        
        $this->_now_db = $dbName;        
        
        return Db::gI();
    }

    public function gTC ($tableName)
    {
        $sql = "SELECT COLUMN_NAME as name , COLUMN_TYPE as type , COLUMN_COMMENT as comment
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE table_name = '{$tableName}'
				AND `TABLE_SCHEMA` = '{$this->_now_db}'
				";
        
        $result = null;
        
        $result = mysql_query($sql);
        
        $rsl = array();
        
        while (false != ($line =mysql_fetch_assoc($result)))
        {
            $rsl[$line['name']] = $line;
        }
               
        mysql_free_result($result);
        
        return $rsl;
    }

    public function q($sql)
    {
        $result = mysql_query($sql);
        
        $rsl = array();
        
        while (false != ($line =mysql_fetch_assoc($result)))
        {
            $rsl[] = $line;
        }
               
        mysql_free_result($result);
        
        return $rsl;
    }
    
    public function gF ($tableName)
    {
        $sql = "SELECT * FROM {$tableName}";
        
        $result = mysql_query($sql);
        
        $rsl = array();
        
        while (false != ($line = mysql_fetch_array($result, MYSQL_ASSOC)))
        {
            $rsl[] = $line;
        }
        
        mysql_free_result($result);
        
        return $rsl;
    }
}

