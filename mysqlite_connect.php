<?php

class MyLiteDB extends SQLite3
{
	function __construct() {
		$this->open('database.db');
	}
}