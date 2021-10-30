<?php

class controller {
	public function loadView($viewName, $viewData = array()){
		require 'views/'.$viewName.'.php';
	}

	public function loadForm($formName, $formData = array()){
		require 'views/'.$formName.'.php';
	}


	public function loadTemplate($viewName, $viewData = array()){
		require 'views/template.php';
	}
	
	public function loadViewInTemplate($viewName, $viewData = array()){
		require 'views/'.$viewName.'.php';
	}

	public function loadAlert(){
		require 'views/alerta.php';
	}
}