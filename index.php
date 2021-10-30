<?php 
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");

session_start();
setlocale(LC_ALL, 'pt_BR.UTF-8');
require "config.php";


if (ENVIRONMENT == 'production') {
	if ($_SERVER["HTTPS"] != "on") {
		header('Location: '.BASE_URL);
	}
	
}




spl_autoload_register(function($class){
	if (file_exists('controllers/'.$class.'.php')) {
		require_once 'controllers/'.$class.'.php';
	}else if (file_exists('models/'.$class.'.php')){
		require_once 'models/'.$class.'.php';
	}else if (file_exists('core/'.$class.'.php')){
		require_once 'core/'.$class.'.php';
	}
});

$core = new Core();
$core->run();