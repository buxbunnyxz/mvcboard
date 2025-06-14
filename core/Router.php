<?php
// core/Router.php

class Router
{
    public function dispatch($url)
    {
        $url = trim($url, '/');

        // Check if the route exists in the routes.php config
        $routes = require ROOT . '/config/routes.php';

        // Default to home page if route doesn't exist
        if (isset($routes[$url])) {
            $controllerName = $routes[$url][0];
            $method = $routes[$url][1];
            $params = array_slice(explode('/', $url), 2);  // Get parameters
        } else {
            $controllerName = 'HomeController';
            $method = 'index';
            $params = [];
        }

        // Initialize controller and method
        $controllerFile = APP . '/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
                return;
            }
        }

        // Fallback 404
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
