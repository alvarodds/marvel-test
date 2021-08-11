<?php
session_start();

require_once 'vendor/autoload.php';
require_once 'helpers/utils.php';
require_once 'config/parameters.php';
require_once 'models/Character.php';
require_once 'views/layout/sidebar.php';


function show_error(){
	$error = new errorController();
	$error->index();
}

if(isset($_GET['controller'])){
	$nombre_controlador = $_GET['controller'].'Controller';
}else if(!isset($_GET['controller']) && isset($_GET['action'])){
	$nombre_controlador = controller_default();
}else{
	show_error();
	exit();
}

if(class_exists($nombre_controlador)){	
	$controlador = new $nombre_controlador();

	if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
		$action = $_GET['action'];
		$controlador->$action();
	}else if(!isset($_GET['controller']) && isset($_GET['action'])){
		$default = action_default();
		$controlador->$default();
	}else{
		show_error();
	}
}else{
	show_error();
}

