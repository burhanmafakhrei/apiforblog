<?php

namespace Application\Services\Router;

use Application\Foundation\Request;
use Application\Middlewares\AuthJwt;
use Application\Services\jsondata\jsondata;

class Router
{
    private static $access = true;
    protected static $baseController = 'Application\\Controllers\\';

    public static function register()
    {
        $currentRoute = self::getCurrentRoute();
        if (self::isRouteDefined($currentRoute)) {
            $routeTarget = self::getRouteTarget($currentRoute);
            self::getMiddleware($routeTarget['middleware']);

            if (self::$access) {
                list($controller, $method) = explode('@', $routeTarget['target']);
                $controllerClass = self::$baseController . $controller;
                $controllerInstance = new $controllerClass;
                if (method_exists($controllerInstance, $method)) {
                    //	$request = new Request();
                    $controllerInstance->$method();
                }


            } else {
                //header('Location: 404.php');
                jsondata::ReturnJson(['action' => 'not access']);
                exit;
            }
        }
    }

    public static function getCurrentRoute()
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    public static function isRouteDefined(string $route)
    {
        $routes = self::getRoutes();
        $routeKey = self::getRouteKey($route);

        return array_key_exists($routeKey, $routes);

    }

    public static function getRoutes()
    {
        $routes = include ABSPATH . DIRECTORY_SEPARATOR . 'routes/web.php';

        return $routes;
    }

    public static function getRouteTarget(string $route)
    {
        $routes = self::getRoutes();
        $routeKey = self::getRouteKey($route);

        return $routes[$routeKey];
    }

    public static function currentRequestVerb()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getRouteKey(string $route)
    {
        return $route . '@' . strtolower(self::currentRequestVerb());
    }

    public static function getMiddleware(string $routeTarget)
    {
        if ($routeTarget) {
            $authjwt = new AuthJwt();
            if (!$authjwt->handle()) {
                self::$access = false;
            }


        }
    }

}