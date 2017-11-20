<?php
namespace Framework\Database;

class DatabaseConnection
{
    protected static $fields = array('host', 'user', 'pass', 'database');

    public function __construct(array $options = array())
    {
        foreach (static::$fields as $field) {
            if (isset($options[$field])) {
                $this->$field = $options[$field];
            } else {
                $this->$field = null;
            }
        }
    }
}
