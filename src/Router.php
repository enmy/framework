<?php
namespace Framework;

/**
 * Clase que administra las url de la aplicación
 * 
 * @author Enmy Perez
 */
class Router implements IRouter
{
    /** @var array Contiene el verbo http, la ruta y el controlador y metodo correspondiente */
    protected static $routes = array();

    protected static $instance = null;

    /** Esta clase no debe ser instanciada */
    protected function __construct() {}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Agrega una ruta sin importar el verbo http
     *
     * @param string $route
     * @param string $controller
     * @param string $method
     * @return void
     */
    public static function add($route, $controller, $method)
    {
        static::getInstance()->createRoute($route, $controller, $method, 'add');
    }

    /**
     * Agrega una ruta para el verbo http get
     *
     * @param string $route
     * @param string $controller
     * @param string $method
     * @return void
     */
    public static function get($route, $controller, $method)
    {
        static::getInstance()->createRoute($route, $controller, $method, 'get');
    }

    /**
     * Agrega una ruta para el verbo http post
     *
     * @param string $route
     * @param string $controller
     * @param string $method
     * @return void
     */
    public static function post($route, $controller, $method)
    {
        static::getInstance()->createRoute($route, $controller, $method, 'post');
    }

    /**
     * Obtiene el controlador y el metodo para la ruta dada.
     *
     * @param string $route La url. Por ejemplo: panel/admin
     * @return array
     * @throws Exception En caso de que la ruta no este definida
     */
    public function getAction($route)
    {
        $uri = $this->parseUri($route);

        if (
            $this->isRequest('GET')
            && isset(static::$routes['get'])
            && array_key_exists($uri, static::$routes['get'])
        ) {
            return static::$routes['get'][$uri];

        } elseif (
            $this->isRequest('POST')
            && isset(static::$routes['post'])
            && array_key_exists($uri, static::$routes['post'])
        ) {
            return static::$routes['post'][$uri];

        } elseif (
            isset(static::$routes['add'])
            && array_key_exists($uri, static::$routes['add'])
        ) {
            return static::$routes['add'][$uri];

        }

        throw new \Exception("La ruta '{$route}' no fue encontrada");
    }

    /**
     * Indica si $_SERVER['REQUEST_METHOD'] es del tipo dado por $verb.
     *
     * @param string $verb El verbo. Por ejemplo: 'GET' | 'POST'
     * @return bool
     */
    public function isRequest($verb)
    {
        return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === $verb;
    }

    /**
     *
     * @param string $uri
     * @return string
     */
    public function parseUri($uri)
    {
        return '/'. trim($uri, '/');
    }

    /**
     *
     * @param string $route
     * @param string $controller
     * @param string $method
     * @param string $http_method
     * @return void
     */
    public function createRoute($route, $controller, $method, $http_method)
    {
        $uri = $this->parseUri($route);

        static::$routes[$http_method][$uri] = array('controller' => $controller, 'method' => $method);
    }
}
