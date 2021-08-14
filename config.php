<?php
require 'environment.php';

ini_set('display_errors', 'on');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/fit/");
	define("APP", "https://raphasfit.com.br/");
	$config['dbname'] = 'fit';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'lucas1231';
} else {
	define("BASE_URL", "http://localhost/psr/psr-4-mvc/");
	$config['dbname'] = 'mvc_psr4';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
}

// URL NOTIFY
define('WEBHOOK','http://localhost/fit/portal/imprimir');

// Gerencianet
$config['gerencianet_clientid'] = '';
$config['gerencianet_clientsecrect'] = '';
$config['gerencianet_sandbox'] = true;

global $db;
try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";charset=utf8;host=".$config['host'], $config['dbuser'], $config['dbpass']);
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}

date_default_timezone_set('America/Sao_Paulo'); 