<?php
namespace Framework\Config;

/**
* 
*/
class Constants
{
    private static $constants = array();

    /** Esta clase no debe ser instanciada */
    private function __construct() {}

    protected static function init()
    {
        if (! empty(static::$constants)) {
            return;
        }

        if (! file_exists(__DIR__.'/const.php')) {
            return;
        }

        $aux = include(__DIR__.'/const.php');

        if (is_array($aux)) {
            static::$constants = $aux;
        }
    }

    public static function get($key)
    {
        static::init();

        $keys = explode('.', $key);

        $aux = static::$constants;

        foreach ($keys as $val) {
            if (isset($aux[$val])) {
                $aux = $aux[$val];
            } else {
                return null;
            }
        }

        return $aux;
    }
}