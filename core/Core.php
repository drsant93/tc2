<?php

class Core {
	public function run(){
		$url = '/';
		if(isset($_GET['url'])){
			$url .= $_GET['url'];
		}
		
		$params = array();

		if (!empty($url) && $url != '/'){
			
			$url = explode('/', $url);
			
			array_shift($url);
			
			$currentController = $url[0].'Controller';
			
			array_shift($url);

			if (isset($url[0]) && !empty($url[0])) {
				$currentAction = $url[0];
			}else{
				$currentAction = 'index';
			}

			array_shift($url);

			if (count($url) > 0) {
				$params = $url;
			}
		}else{
			$currentController = 'homeController';
			$currentAction = 'index';
		}

		if (!file_exists('controllers/'.$currentController.'.php')) {
			header("Location: ".BASE_URL);
		}

		if ($currentController != 'assetsController'){
			$c = new $currentController();

			if (!method_exists($c, $currentAction) || !is_callable(array($c,$currentAction))) {
				header("Location: ".BASE_URL);
			}
	
			call_user_func_array(array($c,$currentAction), $params);
		}
		
		
		
	}

	public function setAlerta($tipo, $mensagem = '', $origem = '', $erro = array()){
		if (isset($erro[1]) && $erro[1] == 1062 && $origem == 'candidato'){
			$_SESSION['alerta']['tipo'] = $tipo;
			$_SESSION['alerta']['mensagem'] = "Cadastro não foi realizado, pois já existem informações do usuário na base.<br>Acesse <a href='".BASE_URL."candidatos/esqueciasenha'>este link</a> para solicitar reenvio dos dados de acesso.";
		}elseif(isset($erro[2])){
			$_SESSION['alerta']['tipo'] = $tipo;
			$_SESSION['alerta']['mensagem'] = $mensagem.$erro[2];
		}elseif(isset($erro) && !empty($erro)){
			$_SESSION['alerta']['tipo'] = $tipo;
			$_SESSION['alerta']['mensagem'] = $mensagem.'<hr>'.json_encode($erro);
		}else{
			$_SESSION['alerta']['tipo'] = $tipo;
			$_SESSION['alerta']['mensagem'] = $mensagem;
		}
	}
}