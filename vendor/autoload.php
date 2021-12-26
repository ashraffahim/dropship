<?php

spl_autoload_register(function($class) {
	if (file_exists('../app/' . str_replace('\\', '/', $class) . '.php')) {
		include '../app/' . str_replace('\\', '/', $class) . '.php';
	}
});

?>