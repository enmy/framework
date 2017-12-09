<?php
namespace Framework;

use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    public function test_add()
    {
        Router::add("home", "MainController", "index");

        $action = Router::getInstance()->getAction("home");

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

        $action = Router::getInstance()->getAction("home");

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

        $action = Router::getInstance()->getAction("home");

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
        Router::getInstance()->getAction('ruta_inexistente');
    }

    public function test_isRequest()
    {
        $router = Router::getInstance();
        $this->assertFalse($router->isRequest('GET'));
        $this->assertFalse($router->isRequest('POST'));

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue($router->isRequest('GET'));
        $this->assertFalse($router->isRequest('POST'));

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertFalse($router->isRequest('GET'));
        $this->assertTrue($router->isRequest('POST'));
    }

    public function test_parseUri()
    {
        $router = Router::getInstance();

        $parse = $router->parseUri('');
        $this->assertTrue(
            $parse === '/'
        );

        $parse = $router->parseUri('/');
        $this->assertTrue(
            $parse === '/'
        );

        $parse = $router->parseUri('home');
        $this->assertTrue(
            $parse === '/home'
        );

        $parse = $router->parseUri('/home');
        $this->assertTrue(
            $parse === '/home'
        );
    }
}