<?php

namespace Application\database;
class Mysql{
    protected $db;
    protected $stmt;
    public function __construct() {
        try {
            $this->db = new \PDO( "mysql:host=localhost;dbname=apiforblog;charset=utf8", "root", "" );
        } catch ( \PDOException $ex ) {
            echo $ex->getMessage();
        }
    }

    public function query(string $sql) {
        $this->stmt = $this->db->prepare($sql);
        $this->stmt->execute();
        return $this->stmt;
    }
	
}

?>