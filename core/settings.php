<?php
	session_start();
	
	# Para accesar a la base de datos
    const DBHOST = 'localhost';
	const DBUSER = 'root';
	const DBPASS = 'olamund0';
	const DBNAME = 'gab2me';
	const HTML = 'static/';
	const WEB_RAIZ = '/';
	const TEMPLATE = 'static/template.html';
	const PRODUCCION = false;
	
	if(PRODUCCION) {
		ini_set('display_errors', '0');
	} else {
		error_reporting(E_ALL);
		ini_set("display_errors", 'On');
	}
	
	require_once('helpers/helper.php');
?>