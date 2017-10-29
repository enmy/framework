<?php

namespace Framework;

/**
* Para mostrar las vistas
*/
class Response
{

    private function __construct() {}

    public static function render($view, $params = array())
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        require_once APP_PATH."views/".$view.".php";
    }

    public static function ajaxDie(array $data = array())
    {
        $json = json_decode($data);

        die($json);
    }
}