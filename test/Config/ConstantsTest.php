<?php
namespace Framework\Config;

use PHPUnit\Framework\TestCase;

final class ConstantsTest extends TestCase
{
    public function test_get()
    {
        $const = Constants::getInstance();

        $this->assertEquals(
            'app/',
            $const->get('PATH.APP')
        );

        $this->assertEquals(
            null,
            $const->get('CONSTANTE.QUE.NO_EXISTE')
        );
    }
}