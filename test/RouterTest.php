<?php

use PHPUnit\Framework\TestCase;
use Framework\Router;

final class RouterTest extends TestCase
{
    public function test_add()
    {
        Router::add("home", "MainController", "index");

        $action = Router::getAction("home");

        $this->assertArraySubset(
            [
                'controller' => 'MainController',
                'method' => 'index'
            ],
            $action
        );
    }

    public function test_get()
    {
        Router::get("home", "MainController", "index");

        $action = Router::getAction("home");

        $this->assertArraySubset(
            [
                'controller' => 'MainController',
                'method' => 'index'
            ],
            $action
        );
    }

    public function test_post()
    {
        Router::post("home", "MainController", "index");

        $action = Router::getAction("home");

        $this->assertArraySubset(
            [
                'controller' => 'MainController',
                'method' => 'index'
            ],
            $action
        );
    }

    public function test_getAction_Exception()
    {
        $this->expectException(\Exception::class);
        Router::getAction("ruta_inexistente");
    }
}