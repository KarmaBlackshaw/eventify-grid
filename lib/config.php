<?php

define('ds', DIRECTORY_SEPARATOR);
define('root', dirname(__DIR__) . ds);
define('models', root . 'models' . ds);
define('controllers', root . 'controllers' . ds);
define('views', root . 'views' . ds);
define('assets', root . 'assets' . ds);
define('css', assets . 'css' . ds);
define('js', assets . 'js' . ds);
define('library', root . 'lib' . ds);
define('vendor', root . 'vendor' . ds);
$base_array = explode(ds, rtrim(root, ds));
define('base', '/' . end($base_array) . '/');
define('Blackshaw', 1);

define('SYSTEM_TITLE', 'Eventify Grid');