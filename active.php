<?php

use App\App;


$file_hash = $_GET['file'];
$ip = $_SERVER['HTTP_CLIENT_IP'];

App::setLiveStatus($file, $ip);

?>