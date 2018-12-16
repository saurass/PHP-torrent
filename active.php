<?php
require_once "vendor/autoload.php";

use App\App;
use App\MyDB as DB;

$db = new DB();
$app = new App($db);

while (1) {
	$app->setLiveStatus();
}

?>