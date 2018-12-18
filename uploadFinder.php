<?php
use App\MyDB;
require_once 'DBInterface.php';
require_once 'connect.php';
$db = new MyDB();
$sqlitedb = new SQLite3('database.db');

// while(1) {
	findNonSharingAndDownloading($db, $sqlitedb);
// }

function findNonSharingAndDownloading($db, $sqlitedb) {
	$query = "SELECT * FROM files WHERE location = '' OR file_size > actual_size";
	$result = $sqlitedb->query($query);
	while($row = $result->fetchArray()) {
		if($row['location'] != '') {

			updateCurrentSize($row['file_hash'], $row['location'], $sqlitedb);
		} else {
			// die('123');
			findAndShareLocation($row['file_hash'], $db, $sqlitedb);
		}
	}
}

function updateCurrentSize($file_hash, $location, $sqlitedb) {
	$file_size = filesize($location);

	$qr1 = "SELECT * FROM files WHERE file_hash = '$file_hash'";
	$res1 = $sqlitedb->query($qr1);
	$row1 = $res1->fetchArray();
	$my_file_size = $row1['file_size'];
	$my_file_size == $file_size ? $dwd_status = 1 : $dwd_status = 0;

	$qrm = "UPDATE files SET actual_size = '$file_size', download_status='$dwd_status' WHERE file_hash='$file_hash'";
	$sqlitedb->exec($qrm);
}

function findAndShareLocation($file_hash, $db, $sqlitedb) {
	$qr1 = "SELECT * FROM files WHERE file_hash = '$file_hash'";
	$res1 = $sqlitedb->query($qr1);
	$row1 = $res1->fetchArray();

	$title = $row1['title'];
	$mime_type = $row1['mime_type'];
	$orig_name = $row1['orig_name'];
	$file_size = $row1['file_size'];

	$qrm = "UPDATE files SET title = '$title', mime_type = '$mime_type', orig_name = '$orig_name', file_size = '$file_size'";
	$sqlitedb->exec($qrm);

	$location = findRecursiveLocation($file_hash, $orig_name);
	$location = str_replace('\\', '/', $location);

	if($location) {
		$qr1 = "UPDATE files SET location = '$location' WHERE file_hash = '$file_hash'";
		$sqlitedb->exec($qr1);
	}
}

function findRecursiveLocation($file_hash, $orig_name) {

	$alphabets = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	for($i = 0; $i < 26; $i++) {
		$dir = $alphabets[$i].":";
		if(is_dir($dir)) {
			return scanDirs($dir, $file_hash);
		}
	}
}

function scanDirs($dir, $file_hash, $i = 0) {
	if($i < 5) {
		$files = scandir($dir);

		foreach($files as $key => $value){

		    $path = realpath($dir.DIRECTORY_SEPARATOR.$value);

		    if(!is_dir($path)) {
		        if(strpos($path, $file_hash) and !strpos($path, 'WINDOWS')){
		            return $path;
		            break;
		        }

		    }
		    if(is_dir($path) and $value != "." && $value != ".." and is_readable($path)) {
		        if($locs = scanDirs($path, $file_hash, $i+1)){
		        	return $locs; 
		        }
		    }  
	 	}
	}
}

?>