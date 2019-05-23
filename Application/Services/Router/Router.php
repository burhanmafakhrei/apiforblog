<?php

namespace Application\Services\Router;

use Application\Foundation\Request;

class Router {
	protected static $baseController = 'Application\\Controllers\\';

	public static function register() {
		$currentRoute = self::getCurrentRoute();
		if ( self::isRouteDefined( $currentRoute ) ) {
			$routeTarget = self::getRouteTarget( $currentRoute );
			list( $controller, $method ) = explode( '@', $routeTarget['target'] );
			$controllerClass    = self::$baseController . $controller;
			$controllerInstance = new $controllerClass;
			if ( method_exists( $controllerInstance, $method ) ) {
				$request = new Request();
				$controllerInstance->$method($request);
			}


		}
		//header('Location: 404.php');
		exit;
	}

	public static function getCurrentRoute() {
		return strtok($_SERVER['REQUEST_URI'],'?');
	}

	public static function isRouteDefined( string $route ) {
		$routes   = self::getRoutes();
		$routeKey = self::getRouteKey( $route );

		return array_key_exists( $routeKey, $routes );

	}

	public static function getRoutes() {
		$routes = include ABSPATH . DIRECTORY_SEPARATOR . 'routes/web.php';

		return $routes;
	}

	public static function getRouteTarget( string $route ) {
		$routes   = self::getRoutes();
		$routeKey = self::getRouteKey( $route );

		return $routes[ $routeKey ];
	}

	public static function currentRequestVerb() {
		return $_SERVER['REQUEST_METHOD'];
	}

	public static function getRouteKey( string $route ) {
		return $route . '@' . strtolower( self::currentRequestVerb() );
	}

}