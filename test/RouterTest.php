<?php
namespace Framework;

use PHPUnit\Framework\TestCase;

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

    public function test_isRequest()
    {
        $this->assertFalse(Router::isRequest('GET'));
        $this->assertFalse(Router::isRequest('POST'));

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue(Router::isRequest('GET'));
        $this->assertFalse(Router::isRequest('POST'));

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertFalse(Router::isRequest('GET'));
        $this->assertTrue(Router::isRequest('POST'));
    }
}