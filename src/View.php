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

        $this->setTemplateDir(Constants::get('PATH.TEMPLATES'));
        $this->setCompileDir(Constants::get('PATH.CACHE'). '/smarty/templates_c/');
        // $this->setConfigDir('/web/www.example.com/guestbook/configs/');
        $this->setCacheDir(Constants::get('PATH.CACHE'). '/smarty/cache/');

        $this->caching = \Smarty::CACHING_LIFETIME_CURRENT;
        $this->assign('app_name', Constants::get('APP_NAME'));
    }
}