<?php
namespace App;

use SNMP;
class App
{
	public $db;

	function __construct(DBConnection $db) {
		$this->db = $db;
	}

	public function boot() {
		$this->findFiles();
		$this->checkServerConfig();
	}

	public function findFiles() {
		$all_files = [];
		$query = "SELECT * FROM files WHERE status = '1'";
		$result = $this->db->query($query);
		while ($row = mysqli_fetch_assoc($result)) {
			$this->printTemplate($row);
		}
	}

	public function checkServerConfig() {
		$get_config = file_get_contents('../settings.json');
		if(strpos($get_config,  '["127.0.0.1", 0]')){
			$host = gethostbyname(trim(`hostname`));
			$str = '["'.$host.'", 80]';
			$get_config = str_replace('["127.0.0.1", 0]', $str, $get_config);
			$handle = fopen('../settings.json', 'w');
			fwrite($handle, $get_config);
			fclose($handle);
			require 'firstTime.php';
		}
	}

	public function printTemplate($file_data) {
		$row = $file_data;
		$content = file_get_contents('template.tub');
		$content = str_replace('TITLE', $row['title'], $content);
		$content = str_replace('FILE_HASH', $row['file_hash'], $content);
		$content = str_replace('MIME_TYPE', $row['mime_type'], $content);
		$content = str_replace('ORIG_NAME', $row['orig_name'], $content);
		$content = str_replace('SERVER_LOC', $row['server_loc'], $content);
		$content = str_replace('FILE_LOC', $row['file_loc'], $content);
		echo $content;
	}

	public static function setLiveStatus($file_hash, $server_loc) {
		$query = "UPDATE files SET status='1' WHERE file_hash = '$file_hash' AND sever_loc = '$server_loc'";
		$this->db->query($query);
	}

}

?>