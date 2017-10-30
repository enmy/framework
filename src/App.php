<?php
namespace Framework;

use Framework\Config\IConfig;
use Framework\Config\Constants;

/**
 * Inicia la aplicacion
 *
 * @author Enmy Perez
 * @version 0.1
 * @since 0.1
 */
class App
{

    /**
     * Busca la ruta, instancia el controlador y ejecuta el metodo
     *
     * @return App
     * @version 0.1
     * @since 0.1
     */
    public function __construct(IConfig $config = null, IRouter $router = null)
    {
        $url = $this->parseUrl();

        if ($config == null) {
            $config = Constants::getInstance();
        }

        if ($router == null) {
            $router = Router::getInstance();
        }

        try {
            $action = $router->getAction($url);

            $controllerName = $action['controller'];
            $method = $action['method'];

            require_once $config->get('PATH.APP').'controllers/'.$controllerName.'.php';

            $controllerFullName = $config->get('NAMESPACE.CONTROLLERS'). $controllerName;

            $controller = new $controllerFullName();

            $controller->$method();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Analiza la url
     *
     * @see public/.htaccess
     * @return void
     * @version 0.1
     * @since 0.1
     */
    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return $_GET['url'];
        }
    }
}