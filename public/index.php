<?php

require '../vendor/session_helper.php';
require '../app/const/config.php';
require '../vendor/autoload.php';

libraries\Route::parseQS($_SERVER['QUERY_STRING']);
libraries\Route::dispatch();

?>