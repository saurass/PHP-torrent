<?php
namespace App;
use COM;
class App
{
	public $db;

	function __construct(DBConnection $db) {
		$this->db = $db;
	}

	public function boot() {
		$this->setLiveStatus();
		$this->startInBackground();
		$this->checkServerConfig();
		require_once 'main-top.php';
		$this->findFiles();
		require_once 'main-bottom.php';
	}

	public function startInBackground() {
		$host = gethostbyname(trim(`hostname`));
		$cmd = "cmd /C cd.. && cd php && php -S $host:8077 -t ../www";
		$WshShell = new COM("WScript.Shell");
		$oExec = $WshShell->Run($cmd, 0, false);
	}

	public function findFiles() {
		$my_ip = file_get_contents('https://api.ipify.org');
		$query = "SELECT * FROM files WHERE status = '1' AND server_pub = '$my_ip'";
		$result = $this->db->query($query);
		while ($row = mysqli_fetch_assoc($result)) {
			$this->printTemplate($row);
		}
	}

	public function checkServerConfig() {
		$host = gethostbyname(trim(`hostname`));
		$str = '["'.$host.'", 8066]';
		$get_config = file_get_contents('../settings.json');
		if(strpos($get_config,  '["127.0.0.1", 0]')){
			$get_config = str_replace('["127.0.0.1", 0]', $str, $get_config);
			$handle = fopen('../settings.json', 'w');
			fwrite($handle, $get_config);
			fclose($handle);
			require 'firstTime.php';
			die();
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

	public function setLiveStatus() {
		$ip = gethostbyname(trim(`hostname`));
		$query = "SELECT * FROM files WHERE server_loc = '$ip'";
		$result = $this->db->query($query);
		while($row = mysqli_fetch_assoc($result)) {
			$fh = $row['file_hash'];
			$timestamp = time();
			if (!file_exists($row['file_loc'])) {
				$qrm = "UPDATE files set status = '0', updated_at = '$timestamp' WHERE server_loc = '$ip' AND file_hash = '$fh'";
				$this->db->query($qrm);
			} else {
				$qrm = "UPDATE files set status = '1', updated_at = '$timestamp' WHERE server_loc = '$ip' AND file_hash = '$fh'";
				$this->db->query($qrm);
			}
		}
	}

}

?>