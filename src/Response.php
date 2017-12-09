<?php
namespace Framework;

/**
* Para mostrar las vistas
*/
class Response
{

    private function __construct() {}

    public static function render($template, $params = array())
    {
        $view = new View;

        $view->assign($params);

        $view->display($template);
    }

    public static function ajaxDie(array $data = array())
    {
        $json = json_decode($data);

        die($json);
    }
}