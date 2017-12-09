<?php
namespace Framework;

use Framework\Config\Env;

if (file_exists(__DIR__. '/../../../smarty/smarty/libs/Smarty.class.php')) {
    require_once __DIR__. '/../../../smarty/smarty/libs/Smarty.class.php';
} elseif (file_exists(__DIR__. '/../vendor/smarty/smarty/libs/Smarty.class.php')) {
    require_once __DIR__. '/../vendor/smarty/smarty/libs/Smarty.class.php';
}

class View extends \Smarty {

    public function __construct()
    {
        parent::__construct();

        $constants = Env::getInstance();

        $this->setTemplateDir($constants->getKey('PATH_TEMPLATES', 'templates/'));
        $this->setCompileDir($constants->getKey('PATH_CACHE', 'cache/'). '/smarty/templates_c/');
        // $this->setConfigDir('/web/www.example.com/guestbook/configs/');
        $this->setCacheDir($constants->getKey('PATH_CACHE', 'cache/'). '/smarty/cache/');

        $this->caching = false;
        $this->assign('app_name', $constants->getKey('APP_NAME'));
    }
}