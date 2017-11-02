<?php
namespace Framework\Config;

/**
* 
*/
class Constants implements IConfig
{
    private static $constants = array();

    private static $instance = null;

    /** Esta clase no debe ser instanciada */
    private function __construct()
    {
        $this->init();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function init()
    {
        if (! empty(self::$constants)) {
            return;
        }

        if (! file_exists(__DIR__.'/const.php')) {
            return;
        }

        $aux = include(__DIR__.'/const.php');

        if (is_array($aux)) {
            self::$constants = $aux;
        }
    }

    public function get($key)
    {
        $keys = explode('.', $key);

        $aux = self::$constants;

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