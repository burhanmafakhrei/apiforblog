<?php

namespace Application\database;


class Mysql
{
    public static $Server   = "localhost";
    static $User     = "root";
    static $Password = "";
    static $DataBaseName = "apiforblog";
    static $Connection;
    static $DataBase;
    static $LoadConnection=0;
    static $CharSet="utf8";

    static $TRANS =false;
    static $TRSS  = array();
    protected $conn;
    public function __construct()
    {
        $this->conn = new \mysqli("localhost", "root", "", "apiforblog");
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }


    }

    public function StartTransaction(){
        Mysql::$TRANS =true;
    }

    public function Commit(){
        mysql_query("SET AUTOCOMMIT = 0");
        mysql_query("START TRANSACTION");
        $K=1;
        foreach (Mysql::$TRSS as $T){
            $L=mysql_query($T);
            $K = $K and $L;
        }
        if($K)
            mysql_query("COMMIT");
        else
            mysql_query("ROLLBACK");
        Mysql::$TRANS =false;
    }

    public function Query($sql){
        if(Mysql::$TRANS==true)
            Mysql::$TRSS[]=$sql;
        else
        {
            return mysql_query($sql);
        }
    }

    public function Fetch($Res){
        return mysql_fetch_assoc($Res);
    }

    public function LastInsertId(){
        return mysql_insert_id();
    }

}



?>