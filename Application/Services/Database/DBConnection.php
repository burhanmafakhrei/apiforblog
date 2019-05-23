<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/26/2017
 * Time: 5:51 PM
 */

namespace Application\Services\Database;


class DBConnection {
	protected $db;
	protected $stmt;
	public function __construct() {
		try {
			$this->db = new \PDO( "mysql:host=localhost;dbname=minishop;charset=utf8", "root", "" );
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