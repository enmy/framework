<?php
namespace Framework;

use PHPUnit\Framework\TestCase;
use Framework\Config\ConstantsMock;

final class AbstractEntityTest extends TestCase
{
    protected $entity;

    public function setUp()
    {
        $this->entity = new EntityMock(array('nombre' => 'test'));
    }

    public function test_entity()
    {
        $this->assertTrue(
            $this->entity->nombre === 'test'
        );

        $this->assertTrue(
            $this->entity->sin_valor === null
        );

        $this->assertTrue(
            $this->entity->getSinAcceso() === 'sin_acceso'
        );
    }
}

class EntityMock extends AbstractEntity
{
    /** @var string Para verificar el setter de las propiedades protegidas */
    protected $sin_acceso;

    protected static $fields = array('nombre', 'sin_valor');

    public function __construct(Array $data = array())
    {
        parent::__construct($data);

        $this->sin_acceso = 'sin_acceso';
    }

    public function getSinAcceso()
    {
        return $this->sin_acceso;
    }
}