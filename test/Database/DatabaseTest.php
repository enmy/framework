<?php
namespace Framework\Database;

use PHPUnit\Framework\TestCase;

final class DatabaseTest extends TestCase
{
    public function test_connection()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection([
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'database' => 'servicio_tecnico',
            ])
        );

        $this->assertInstanceOf(
            Database::class,
            $db
        );
    }
}