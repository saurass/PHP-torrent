<?php
namespace App;

interface DBConnection
{
	public function query($query);
}

?>