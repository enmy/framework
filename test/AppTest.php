<?php
namespace Framework;

use PHPUnit\Framework\TestCase;
use Framework\Config\ConstantsMock;

final class AppTest extends TestCase
{
    public function test_instantiate()
    {
        Router::add("home", "MockController", "about");
        $_GET['url'] = 'home';
        $this->expectOutputString('Hola desde about');

        $app = new App(new ConstantsMock);
    }
}