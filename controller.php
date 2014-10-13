<?php
require_once('core/settings.php');
	
	$pval = array_values($_POST);
	$pkey = array_keys($_POST);
	$gval = array_values($_GET);
	$gkey = array_keys($_GET);

	for ($i=0,$t=count($pkey); $i < $t; $i++) {
		$_POST["$pkey[$i]"] = helper::sanitize($pval[$i]);
	}
	
	for ($i=0,$t=count($gkey); $i < $t; $i++) {
		$_GET["$gkey[$i]"] = helper::sanitize($gval[$i]);
	}
	
	if(isset($_GET['modulo']) && !isset($_GET['action'])){
		$modulo = './modules/' . $_GET['modulo'] . '/controller/' . $_GET['modulo'] . 'Controller.php';
		if(is_file($modulo)){
			require_once($modulo);
			$class = $_GET['modulo'] . 'Controller';
			$class = new $class();
			$class->index();
		}else{
			header("Locaton: /404.html");
		}
	}else if(isset($_GET['modulo'],$_GET['action'])){
		$controller = './modules/' . $_GET['modulo'] . '/controller/' . $_GET['modulo'] . 'Controller.php';
		$clase = $_GET['modulo'].'Controller';
		$method = $_GET['action'];
		if(is_file($controller)){
			require_once ($controller);
			$class = new $clase();
			$validar = array($class,$method);
			if(is_callable($validar)){
				$class->$method();
			}else{
				header("Location: /404.html");
			}
		}else{
			header("Location: /404.html");
		}				
	}else{
		$modulo = './modules/user/controller/userController.php';
		if(is_file($modulo)){
			require_once($modulo);
			$class = new userController();
			$class->home();
		}else{
			header("Location: /404");
		}
	}
?>