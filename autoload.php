<?php
spl_autoload_register(function($className) {

		$file = DIR__PATH . 'inc/' . $className . '.php';

		if (file_exists($file)) {
			include $file;
		}

});