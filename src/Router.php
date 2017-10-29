<?php

namespace Framework;

/**
 * Clase que administra las url de la aplicación
 * 
 * @author Enmy Perez
 * @version 0.2
 * @since 0.1
 */
class Router
{
    /** @var array Contiene el verbo http, la ruta y el controlador y metodo correspondiente */
    private static $routes = array();
    
    /** Esta clase no debe ser instanciada */
    private function __construct() {}

    /**
     * Agrega una ruta sin importar el verbo http
     *
     * @param string $route
     * @param string $controller
     * @param string $method
     * @return void
     * @since 0.1
     */
    public static function add($route, $controller, $method)
    {
        static::$routes["add"][$route] = ["controller" => $controller, "method" => $method];
    }

    /**
     * Agrega una ruta para el verbo http get
     *
     * @param string $route
     * @param string $controller
     * @param string $method
     * @return void
     * @since 0.2
     */
    public static function get($route, $controller, $method)
    {
        static::$routes["get"][$route] = ["controller" => $controller, "method" => $method];
    }

    /**
     * Agrega una ruta para el verbo http post
     *
     * @param string $route
     * @param string $controller
     * @param string $method
     * @return void
     * @since 0.2
     */
    public static function post($route, $controller, $method)
    {
        static::$routes["post"][$route] = ["controller" => $controller, "method" => $method];
    }

    /**
     * Obtiene el controlador y el metodo para la ruta dada.
     *
     * @param string $route La url. Por ejemplo panel/admin
     * @return array
     * @throws Exception En caso de que la ruta no este definida
     * @version 0.2
     * @since 0.1
     */
    public static function getAction($route)
    {
        // $_SERVER["REQUEST_METHOD"] da problemas cuando se corren
        // las pruebas con phpunit y no esta definido
        if (!isset($_SERVER["REQUEST_METHOD"])) {
            $_SERVER["REQUEST_METHOD"] = "GET";
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET"
            && isset(static::$routes["get"])
            && array_key_exists($route, static::$routes["get"])
        ) {
            return static::$routes["get"][$route];

        } else if ($_SERVER["REQUEST_METHOD"] == "POST"
            && isset(static::$routes["post"])
            && array_key_exists($route, static::$routes["post"])
        ) {
            return static::$routes["post"][$route];

        } else if (isset(static::$routes["add"])
            && array_key_exists($route, static::$routes["add"])
        ) {
            return static::$routes["add"][$route];

        }

        throw new \Exception("La ruta '{$route}' no fue encontrada");
    }
}