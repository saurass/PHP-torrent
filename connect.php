<?php
namespace App;
use SQLite3;

class MyDB extends SQLite3 implements DBConnection
{
	private $conn;

	function __construct() {
		$this->open('database.db');
		$this->conn = mysqli_connect('10.10.10.220','technocrats','password','dfiles');
	}

	public function query($query) {
		return $this->conn->query($query);
	}
}

?>