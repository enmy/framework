<?php
namespace Framework;

/**
 * Clase que administra las url de la aplicación
 * 
 * @author Enmy Perez
 * @version 0.2
 * @since 0.1
 */
class Router implements IRouter
{
    /** @var array Contiene el verbo http, la ruta y el controlador y metodo correspondiente */
    private static $routes = array();

    private static $instance = null;

    /** Esta clase no debe ser instanciada */
    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

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
        self::$routes['add'][$route] = array('controller' => $controller, 'method' => $method);
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
        self::$routes['get'][$route] = array('controller' => $controller, 'method' => $method);
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
        self::$routes['post'][$route] = array('controller' => $controller, 'method' => $method);
    }

    /**
     * Obtiene el controlador y el metodo para la ruta dada.
     *
     * @param string $route La url. Por ejemplo: panel/admin
     * @return array
     * @throws Exception En caso de que la ruta no este definida
     * @version 0.2
     * @since 0.1
     */
    public function getAction($route)
    {
        if (
            $this->isRequest('GET')
            && isset(self::$routes['get'])
            && array_key_exists($route, self::$routes['get'])
        ) {
            return self::$routes['get'][$route];

        } elseif (
            $this->isRequest('POST')
            && isset(self::$routes['post'])
            && array_key_exists($route, self::$routes['post'])
        ) {
            return self::$routes['post'][$route];

        } elseif (
            isset(self::$routes['add'])
            && array_key_exists($route, self::$routes['add'])
        ) {
            return self::$routes['add'][$route];

        }

        throw new \Exception("La ruta '{$route}' no fue encontrada");
    }

    /**
     * Indica si $_SERVER['REQUEST_METHOD'] es del tipo dado por $verb.
     *
     * @param string $verb El verbo. Por ejemplo: 'GET' | 'POST'
     * @return bool
     * @since 0.2
     */
    public function isRequest($verb)
    {
        return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === $verb;
    }
}
