<?php
namespace Framework\Database;

use PHPUnit\Framework\TestCase;

final class MYSQLDatabaseTest extends TestCase
{
    public function test_connection()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection([
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'database' => 'mysql',
            ])
        );

        $this->assertInstanceOf(
            Database::class,
            $db
        );
    }

    public function test_connection_exception()
    {
        $this->expectException(\Exception::class);

        $db = new MYSQLDatabase(
            new DatabaseConnection([
                'host' => 'localhost',
                'user' => '',
                'pass' => '',
                'database' => 'mysql',
            ])
        );
    }

    public function test_selecionar_bd_exception()
    {
        $this->expectException(\Exception::class);

        $db = new MYSQLDatabase(
            new DatabaseConnection([
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                // 'database' => 'mysql',
            ])
        );
    }

    public function test_query()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection([
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'database' => 'mysql',
            ])
        );

        $return = $db->query(
            '
                SELECT user,host
                FROM user
            '
        );

        $this->assertInstanceOf(
            Database::class,
            $return
        );
    }

    public function test_query_exception()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection([
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'database' => 'mysql',
            ])
        );

        $this->expectException(\Exception::class);

        $return = $db->query(
            '
                SELECT user,host,columna_que_no_existe
                FROM user
            '
        );
    }

    public function test_fetchRow()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection([
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'database' => 'mysql',
            ])
        );

        $return = $db->query(
            '
                SELECT user,host
                FROM user
            '
        )->fetchRow();

        $keys = ['user', 'host', 0, 1];

        foreach ($keys as $key) {
            $this->assertArrayHasKey(
                $key,
                $return
            );
        }
    }

    public function test_getRow()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection([
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'database' => 'mysql',
            ])
        );

        $return = $db->getRow(
            '
                SELECT user,host
                FROM user
            '
        );

        $keys = ['user', 'host', 0, 1];

        foreach ($keys as $key) {
            $this->assertArrayHasKey(
                $key,
                $return
            );
        }
    }
}