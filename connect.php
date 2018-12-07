<?php
namespace App;

class MyDB implements DBConnection
{
	private $conn;

	function __construct() {
		$this->conn = mysqli_connect('sql12.freemysqlhosting.net', 'sql12268939', 'qvZkzjgz9C', 'sql12268939');
	}

	public function query($query) {
		return $this->conn->query($query);
	}
}

?>