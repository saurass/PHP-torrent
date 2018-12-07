<?php
error_reporting(0);
require_once "vendor/autoload.php";

use App\App;
use App\MyDB as DB;
/*
|===============================================
|   ignite App here using App::boot()
|===============================================
*/
$db = new DB();
$app = new App($db);

$app->boot();

?>