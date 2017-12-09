<?php
namespace Framework\Config;

use PHPUnit\Framework\TestCase;

final class EnvTest extends TestCase
{
    public function test_get()
    {
        $_ENV['test'] = 'test';

        $env = Env::getInstance();

        $this->assertTrue(
            $env->getKey('test') === 'test'
        );

        $this->assertTrue(
            $env->getKey('no_existe') === null
        );

        $this->assertTrue(
            $env->getKey('no_existe', 'default') === 'default'
        );
    }

    public function test_get_static()
    {
        $_ENV['test'] = 'test';

        $this->assertTrue(
            Env::get('test') === 'test'
        );

        $this->assertTrue(
            Env::get('no_existe') === null
        );

        $this->assertTrue(
            Env::get('no_existe', 'default') === 'default'
        );
    }
}