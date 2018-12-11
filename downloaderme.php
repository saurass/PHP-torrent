<?php
require_once 'mysqlite_connect.php';

$db = new MyLiteDB();
$file_hash = $_GET['file_hash'];
$filename = getFileLoc($db, $file_hash);

require_once 'downloader.php';


function getFileLoc($db, $file_hash) {
	$qrm = "SELECT location FROM files WHERE file_hash = '$file_hash'";
	$res = $db->query($qrm);
	$row = $res->fetchArray(SQLITE3_ASSOC);
	return $row['location'];
}

?>