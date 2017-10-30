<?php
namespace Framework;

use Framework\Config\Constants;
use PHPUnit\Framework\TestCase;

final class AppTest extends TestCase
{
    public function test_instantiate()
    {
        Router::add("home", "MainController", "about");
        $_GET['url'] = 'home';
        $this->expectOutputString('Hola desde about');

        $app = new App;
    }
}