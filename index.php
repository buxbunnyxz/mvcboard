<?php
// index.php in htdocs/

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', ROOT . '/php-errors.log');  // Custom log location
error_reporting(E_ALL);

session_start();

define('ROOT', __DIR__);
define('APP', ROOT . '/app');
define('CORE', ROOT . '/core');

// Load Lang before routing
require_once CORE . '/Lang.php';
Lang::init('en');

spl_autoload_register(function ($class) {
    $paths = [CORE, APP . '/controllers', APP . '/models'];
    foreach ($paths as $path) {
        $file = "$path/$class.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once CORE . '/Router.php';
$router = new Router();
$router->dispatch($_GET['url'] ?? '');
