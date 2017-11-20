<?php
namespace Framework;

use Framework\Config\Constants;

if (file_exists(__DIR__. '/../../../smarty/smarty/libs/Smarty.class.php')) {
    require_once __DIR__. '/../../../smarty/smarty/libs/Smarty.class.php';
} elseif (file_exists(__DIR__. '/../vendor/smarty/smarty/libs/Smarty.class.php')) {
    require_once __DIR__. '/../vendor/smarty/smarty/libs/Smarty.class.php';
}

class View extends \Smarty {

    public function __construct()
    {
        parent::__construct();

        $constants = Constants::getInstance();

        $this->setTemplateDir($constants->get('PATH.TEMPLATES'));
        $this->setCompileDir($constants->get('PATH.CACHE'). '/smarty/templates_c/');
        // $this->setConfigDir('/web/www.example.com/guestbook/configs/');
        $this->setCacheDir($constants->get('PATH.CACHE'). '/smarty/cache/');

        $this->caching = false;
        $this->assign('app_name', $constants->get('APP_NAME'));
    }
}
