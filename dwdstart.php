<?php
require_once 'mysqlite_connect.php';

$db = new MyLiteDB();
$file_hash = $_GET['file_hash'];

$qrm = "INSERT INTO files VALUES ('', '$file_hash', '', '', '')";
$res = $db->exec($qrm);