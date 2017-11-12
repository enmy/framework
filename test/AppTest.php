<?php
namespace Framework;

use Framework\Config\ConstantsMock;
use PHPUnit\Framework\TestCase;

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