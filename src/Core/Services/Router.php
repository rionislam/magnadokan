<?php
namespace Core\Services;

use Core\Application;

class Router
{
    private static array $routes = [];

    public static function get($path, $handler)
    {
        self::$routes['GET'][$path] = $handler;
    }

    public static function post($path, $handler)
    {
        self::$routes['POST'][$path] = $handler;
    }

    public static function put($path, $handler)
    {
        self::$routes['PUT'][$path] = $handler;
    }

    public static function del($path, $handler)
    {
        self::$routes['DELETE'][$path] = $handler;
    }

    public static  function dispatch()
    {
        ob_start();
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        foreach (self::$routes[$method] as $route => $handler) {
            if (self::matchesRoute($path, $route)) {
                self::callHandler($handler, $route);
                return;
            }
        }

        // Handle 404 error
        ErrorHandler::displayErrorPage(404);
       
    }

    private static function matchesRoute($path, $route)
    {
        $regex = str_replace(['/', '{', '}'], ['\/', '(?P<', '>[^\/]+)'], $route);
        $regex = '/^' . $regex . '$/';

        return preg_match($regex, $path, $matches);
    }

    private static function callHandler($handler, $route)
    {
        list($controller, $method) = explode('@', $handler);
        $controllerFile = Application::$ROOT_DIR.'/src/Core/Controllers/' . $controller . '.php';

        if (file_exists($controllerFile)) {
            $controllerClass = "Core\\Controllers\\".$controller;

            $controllerInstance = new $controllerClass();

            // Extract dynamic route parameters
            $params = self::extractRouteParameters($route);
            $controllerInstance->$method(...$params);
        } else {
            // Handle 404 error
            ErrorHandler::displayErrorPage(404);
        }
    }

    private static function extractRouteParameters($route)
    {
        $params = [];

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if(preg_match_all('/{([^}]+)}/', $route, $matches)){
            $regex = str_replace(['/', '{', '}'], ['\/', '(?P<', '>[^\/]+)'], $route);
            $regex = '/^' . $regex . '$/';
            preg_match($regex, $path, $matches2);
            foreach($matches[1] as $matche){
                if(isset($matches2[$matche])){
                    $params[] = $matches2[$matche];
                }
            }
        }

        return $params;
    }
}