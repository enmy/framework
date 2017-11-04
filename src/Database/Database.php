<?php
namespace Framework\Database;

abstract class Database implements DatabaseInterface
{
    protected $link = null;
    protected $begin_transaction = false;
    protected $id_query = null;
    protected $db_connection = null;

    public function __construct(DatabaseConnection $db_connection = null)
    {
        if ($db_connection == null) {
            $db_connection = new DatabaseConnection([
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'database' => '',
            ]);
        }

        $this->db_connection = $db_connection;
    }
}