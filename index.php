<?php

use App\App;
use App\MyDB as DB;

require_once "vendor/autoload.php";
/*
|===============================================
|   ignite App here using App::boot()
|===============================================
*/
$db = new DB();
$app = new App($db);

$app->boot();

?>