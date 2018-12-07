<?php
namespace App;


use SQLite3;

class MyDB implements DBConnection
{
	private $conn;

	function __construct() {
		$this->conn = mysqli_connect('host', 'user', 'pass', 'tble');
	}

	public function query($query) {
		return $this->conn->query($query);
	}
}

?>