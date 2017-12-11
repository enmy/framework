<?php
namespace Framework;

/**
 * AbstractEntity
 * Clase base para los llamados Objetos del Dominio.
 */
abstract class AbstractEntity
{
    protected static $fields = array();

    public function __construct(Array $data = array())
    {
        foreach (static::$fields as $field) {
            if (isset($data[$field])) {
                $this->$field = $data[$field];
            }
            else {
                $this->$field = null;
            }
        }
    }

    /*
     * Los setter de la entidad deben tener el 
     * prefijo 'set' y el nombre de la variable con
     * la primera letra en mayúscula. Si la variable
     * empieza con guión bajo (_), solo se debe agregar
     * el prefijo 'set'. El setter no es obligatorio.
     * @example
     *      protected static $fields = array('primer_nombre');
     *      public setPrimer_nombre(){}
     *      protected $_db;
     *      public set_db(){}
     */
    public function __set($name, $value)
    {
        if (! in_array($name, static::$fields)) {
            return;
        }

        $mutator = 'set'. ucfirst($name);
        if (method_exists($this, $mutator) && is_callable(array($this, $mutator))) {
            $this->$mutator($value);
        }
        else {
            $this->$name = $value;
        }
    }
}