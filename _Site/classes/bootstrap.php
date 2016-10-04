<?php
/**
 * @author Andrey A. Nechaev <nechaev@nmgcom.ru>
 * @copyright Copyright (c) 2015 Nechaev Marketing Group (http://www.nmgcom.ru)
 */

spl_autoload_register(function ($className) {
	$className = str_replace("\\","/",$className);

	$path = __DIR__.'/'.$className.'.php';
	if (file_exists($path)) {
		require_once($path);
		return true;
	}

	return false;
});

define('HOMEDIR', dirname(__DIR__));