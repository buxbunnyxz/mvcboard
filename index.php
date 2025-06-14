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

// Manually parse URL and route it
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';

// Split URL into controller and method
$parts = explode('/', $url);

// Default controller
$controllerName = !empty($parts[0]) ? ucfirst($parts[0]) . 'Controller' : 'HomeController';
$method = $parts[1] ?? 'index';
$params = array_slice($parts, 2);

// Load controller file
$controllerFile = APP . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();

    // Check if method exists
    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
        return;
    }
}

// Fallback 404
http_response_code(404);
echo "404 - Page Not Found";
