<?php
//load config
require_once "config/config.php";
//autolaod core libraries
spl_autoload_register(function($class_name){
	require_once 'libraries/' . $class_name . '.php';
});
