<?php

use PHPUnit\Framework\TestCase;
use Framework\Router;

final class RouterTest extends TestCase
{
    public function test_Router_add()
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
}