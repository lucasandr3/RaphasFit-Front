<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

require 'config.php';
require 'vendor/autoload.php';
require 'helpers/functions.php';
require 'helpers/Minify.php';
require 'routers.php';

$core = new Core\Core();
$core->run();