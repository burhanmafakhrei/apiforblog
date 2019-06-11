<?php

namespace Application\database;

use Application\Services\jsondata\jsondata;

class Model extends Mysql
{

    protected $datamembers = array();
    protected $PrimaryKey = "Id";
    protected $TableName = "Table";
    public $UnProtectedExecute = FALSE;
    static $id = 12;


    public function __set($variable, $value)
    {
        $this->datamembers[strtolower($variable)] = $value;
    }

    public function __get($variable)
    {
        return $this->datamembers[strtolower($variable)];
    }

    public function HasField($name)
    {
        return isset($this->datamembers[strtolower($name)]);
    }

    public function HasRecord($cond)
    {
        return $this->Count($cond) > 0;
    }

    public function Select($cond = "", $fields = "*", $order = "", $limit = "", $EXT = "")
    {
        if ($cond != "") $cond = " Where $cond";
        if ($order != "") $order = " Order By $order";
        if ($limit != "") $limit = " LIMIT $limit";
        $table = $this->TableName;
        $sql = "SELECT $fields From $table $cond  $EXT $order $limit";

        $result = array();
        $r = $this->Query($sql);

        while ($row = $this->Fetch($r)) {
            $t = clone $this;
            foreach ($row as $k => $v) {
                $k = strtolower($k);
                $t->$k = $v;
            }
            $result[] = $t;
        }
        return $result;
    }

    public function Count($cond = "")
    {
        if ($cond != "") $cond = " Where " . $cond;
        $table = $this->TableName;
        $r = $this->Query("select count(*) as cntx from $table $cond");
        $row = $this->Fetch($r);
        return $row['cntx'];
    }

    public function Sum($field, $cond = "")
    {
        if ($cond != "") $cond = " Where " . $cond;
        $table = $this->TableName;
        $r = $this->Query("select sum($field) as sumx from $table $cond");
        $row = $this->Fetch($r);
        return intval($row['sumx']);
    }

    public function Max($field, $cond = "")
    {
        if ($cond != "") $cond = " Where " . $cond;
        $table = $this->TableName;
        $r = $this->Query("select Max(`$field`) as mx from `$table` $cond");
        $row = $this->Fetch($r);
        return $row['mx'];
    }

    public function All()
    {
        return $this->Select();
    }

    public function Limit($limit = 10, $cond = "", $order = "")
    {
        return $this->Select($cond, "*", $order, $limit);
    }

    public function Filter($cond, $order = "")
    {
        return $this->Select($cond, "*", $order);
    }

    public function FindByCond($cond)
    {
        $table = $this->TableName;
        $fd = $this->Select($cond);
        if (count($fd) > 0)
            return $fd[0];
    }

    public function Find($field, $value, $op = "=")
    {
        /* $fd = ($this->Select($field . $op . "'" . $this->ReadyString($value) . "'"));
         if (count($fd) > 0)
             return $fd[0];*/


        //  $sql = "SELECT id, firstname, lastname FROM MyGuests";
        $sql = "SELECT * FROM $this->TableName WHERE $field$op'$value'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
           return true;
        } else {
           return false;
        }
      //  $conn->close();
    }

    public function findBy($criteria)
    {

        //$where="user_email='email.gmail.com' AND user_password='c4ca4238a0b923820dcc509a6f75849b'";
        $where='';
        foreach ($criteria as $key => $value){
            $where=$where. $key.'='.$value.' AND ';
        }
        $sql = "SELECT * FROM $this->TableName WHERE $where";
        //var_dump($sql);
        jsondata::ReturnJson(['q'=>$sql]);

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function FindAll($cond = "")
    {
        return $this->Select($cond);
    }

    public function FindByKey($key)
    {
        $fd = $this->Select($this->PrimaryKey . "=" . $this->ReadyString($key));
        if (count($fd) > 0)
            return $fd[0];
    }

    public function UpdateByCond($cond, $field = "*")
    {
        $ff = array();
        $table = $this->TableName;
        if ($field == "*") {
            foreach ($this->datamembers as $k => $v)
                if ($k != $this->PrimaryKey)
                    $ff[] = "`" . $k . "`='" . $this->ReadyString($v) . "'";
            $ff = implode(",", $ff);
        } else {
            $ff = "`$field`='" . $this->$field . "'";
        }


        $sql = "UPDATE `$table` SET $ff where $cond";
        $this->Query($sql);
    }

    public function Update($field = "*")
    {
        $cond = $this->PrimaryKey;

        if ($cond != "" && $this->HasField($cond))
            $cond = " WHERE `$cond` ='" . $this->ReadyString($this->$cond) . "'";
        else
            $cond = "";
        $this->UpdateByCond($cond, $field);
    }

    public function Clear()
    {
        $table = $this->TableName;
        $this->Query("TRUNCATE TABLE `$Table`");
    }

    public function Delete($key = "")
    {
        $table = $this->TableName;
        $k = $this->PrimaryKey;
        $v = $key;
        $sql = "DELETE FROM $table WHERE `$k`='$v'";
        $this->Query($sql);
    }

    public function getLastKey()
    {
        $mx = $this->Max($this->PrimaryKey);
        return $mx;
    }

    public function save(array $save)
    {
        $fs = array();
        $vs = array();
        $table = $this->TableName;

        foreach ($save as $k => $v) {
            $fs[] = "`" . $k . "`";
            $vs[] = "'" . $this->ReadyString($v) . "'";
        }

        $fs = implode(",", $fs);
        $vs = implode(",", $vs);

        $sql = "INSERT INTO $table ($fs) VALUES ($vs) ";

        if ($this->conn->query($sql) === TRUE) {

            return true;
        } else {
            return false;
        }
        $this->conn->close();
    }

    public function ReadyString($value)
    {
        return addslashes($value);
    }

}


?>