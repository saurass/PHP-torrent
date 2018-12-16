<?php
use App\MyDB;
require_once 'DBInterface.php';
require_once 'connect.php';
$db = new MyDB();
findAndShareLocation('aman', $db);

// while(1) {
// 	findAndShare();
// }

function findNonSharingAndDownloading() {
	$query = "SELECT * FROM files WHERE location = '' OR actual_size > file_size";
	$result = $db->exec();
	while($row = mysqli_fetch_assoc($query)) {
		if($row['actual_size'] > 0) {
			updateCurrentSize($row['file_hash'], $row['location']);
		} else {
			findAndShareLocation($row['file_hash']);
		}
	}
}

function updateCurrentSize($file_hash, $location) {
	$file_size = filesize($location);
	$qrm = "UPDATE files SET actual_size = '$file_size'";
	$db->exec($qrm);
}

function findAndShareLocation($file_hash, $db) {
	$qr1 = "SELECT * FROM files WHERE file_hash = '$file_hash'";
	$res1 = $db->query($qr1);
	$row1 = mysqli_fetch_assoc($res1);

	$title = $row1['title'];
	$mime_type = $row1['mime_type'];
	$orig_name = $row1['orig_name'];
	$file_size = $row1['file_size'];

	$qrm = "UPDATE files SET title = '$title', mime_type = '$mime_type', orig_name = '$orig_name', file_size = '$file_size'";
	$db->exec($qrm);

	$location = findRecursiveLocation($file_hash, $orig_name);

	if($location) {
		$qr1 = "UPDATE files SET location = '$location' WHERE file_hash = '$file_hash'";
		$db->exec($qr1);
	}
}

function findRecursiveLocation($file_hash, $orig_name) {

	$alphabets = "DEFGHIJKLMNOPQRSTUVWXYZ";
	for($i = 0; $i < 26; $i++) {
		$dir = $alphabets[$i].":";
		if(is_dir($dir)) {
			return scanDirs($dir, $file_hash);
		}
	}
}

function scanDirs($dir, $file_hash) {
	$files = scandir($dir);

	foreach($files as $key => $value){

	    $path = realpath($dir.DIRECTORY_SEPARATOR.$value);

	    if(!is_dir($path)) {

	        if(strpos($value, $file_hash)){
	            return $path;
	            break;
	        }

	    }
	    if(is_dir($path) and $value != "." && $value != ".." and is_readable($path)) {
	        scanDirs($path, $file_hash);
	    }  
 	} 
}

?>