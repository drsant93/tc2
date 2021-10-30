<?php 
date_default_timezone_set('America/Sao_Paulo');
require 'environment.php';

$config = array();


if (ENVIRONMENT == 'development') {
	define("BASE_URL","http://localhost/tc1/");
	$config['dbname'] = 'receituario';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = ''; 
} else {
	define("BASE_URL","https://tc1.ktrindade.com.br/");
	$config['dbname'] = 'ktrind95_receituario';
	$config['host'] = 'ktrindade.com.br';
	$config['dbuser'] = 'ktrind95_douglas';
	$config['dbpass'] = '952884466';
}


global $db;

try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'].";charset=utf8",$config['dbuser'],$config['dbpass']);
} catch(PDOException $e){
	echo "ERRO: ".$e->getmessage();
	exit;
}