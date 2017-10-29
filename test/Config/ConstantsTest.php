<?php
namespace Framework\Config;

use PHPUnit\Framework\TestCase;

final class ConstantsTest extends TestCase
{
    public function test_get()
    {
        $this->assertEquals(
            'app/',
            Constants::get('PATH.APP')
        );
        $this->assertEquals(
            null,
            Constants::get('CONSTANTE.QUE.NO_EXISTE')
        );
    }
}