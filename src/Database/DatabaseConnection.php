<?php
namespace Framework\Database;

class DatabaseConnection
{
    protected static $fields = ['host', 'user', 'pass', 'database'];

    public function __construct(array $options = [])
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