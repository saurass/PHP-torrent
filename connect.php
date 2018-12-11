<?php
namespace App;
use SQLite3;
class MyDB extends SQLite3 implements DBConnection
{
	private $conn;

	function __construct() {
		$this->open('database.db');
		$this->conn = mysqli_connect('sql12.freemysqlhosting.net','sql12268939','qvZkzjgz9C','sql12268939');
	}

	public function query($query) {
		return $this->conn->query($query);
	}
}

?>