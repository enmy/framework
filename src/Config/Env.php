<?php
namespace Framework\Config;

/**
 * 
 */
class Env implements IConfig
{
    protected static $instance = null;

    /** Esta clase no debe ser instanciada */
    protected function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getKey($key, $default = null)
    {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        return $default;
    }

    public static function get($key, $default = null)
    {
        return static::getInstance()->getKey($key, $default);
    }
}