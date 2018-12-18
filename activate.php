<?php
if (!isset($_GET['act']) or $_GET['act'] != 0) {

	$cmd = "cmd /C cd.. && cd php && php ../www/active.php";
	$WshShell = new COM("WScript.Shell");
	$oExec = $WshShell->Run($cmd, 0, false);

}

?>