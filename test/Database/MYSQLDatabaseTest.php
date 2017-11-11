<?php
namespace Framework\Database;

use PHPUnit\Framework\TestCase;

final class MYSQLDatabaseTest extends TestCase
{

    public $db_connection = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'database' => 'mysql',
    ];

    public $db_connection_test = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'database' => 'test',
    ];

    public $query = '
        SELECT user,host
        FROM user
    ';

    public function test_connection()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->assertInstanceOf(
            Database::class,
            $db
        );
    }

    public function test_connection_exception()
    {
        $this->expectException(\Exception::class);

        $db_connection = $this->db_connection;
        $db_connection['user'] = '';

        $db = new MYSQLDatabase(
            new DatabaseConnection($db_connection)
        );
    }

    public function test_selecionar_bd_exception()
    {
        $this->expectException(\Exception::class);

        $db_connection = $this->db_connection;
        unset($db_connection['database']);

        $db = new MYSQLDatabase(
            new DatabaseConnection($db_connection)
        );
    }

    public function test_query()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $return = $db->query($this->query);

        $this->assertInstanceOf(
            Database::class,
            $return
        );
    }

    public function test_query_exception()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->expectException(\Exception::class);

        $return = $db->query(
            '
                SELECT user,host,columna_que_no_existe
                FROM user
            '
        );
    }

    public function test_isIdQuery_true()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $db->query($this->query);

        $this->assertTrue(
            $db->isIdQuery() === true
        );
    }

    public function test_isIdQuery_false()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->assertTrue(
            $db->isIdQuery(false) === false
        );
    }

    public function test_isIdQuery_exception()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->expectException(\Exception::class);

        $db->isIdQuery();
    }

    public function test_fetchRow()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $return = $db->query($this->query)->fetchRow();

        $keys = ['user', 'host'];

        foreach ($keys as $key) {
            $this->assertObjectHasAttribute(
                $key,
                $return
            );
        }
    }

    public function test_fetchRow_exception()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->expectException(\Exception::class);

        $db->fetchRow();
    }

    public function test_getRow()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $return = $db->getRow($this->query);

        $keys = ['user', 'host'];

        foreach ($keys as $key) {
            $this->assertObjectHasAttribute(
                $key,
                $return
            );
        }
    }

    public function test_getRow_exception()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->expectException(\Exception::class);

        $db->getRow(
            '
                SELECT user,host,columna_que_no_existe
                FROM user
            '
        );
    }

    public function test_fetchRowArray()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $return = $db->query($this->query)->fetchRowArray();

        $keys = ['user', 'host', 0, 1];

        foreach ($keys as $key) {
            $this->assertArrayHasKey(
                $key,
                $return
            );
        }
    }

    public function test_fetchRowArray_exception()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->expectException(\Exception::class);

        $db->fetchRowArray();
    }

    public function test_fetchAllRow()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $return = $db->query($this->query)->fetchAllRow();

        $this->assertTrue(
            is_array($return) === true
        );

        $this->assertTrue(
            count($return) > 1
        );
    }

    public function test_fetchAllRow_exception()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->expectException(\Exception::class);

        $return = $db->fetchAllRow();
    }

    public function test_fetchAllRowArray()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $return = $db->query($this->query)->fetchAllRowArray();

        $this->assertTrue(
            is_array($return) === true
        );

        $this->assertTrue(
            count($return) > 1
        );
    }

    public function test_fetchAllRowArray_exception()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->expectException(\Exception::class);

        $return = $db->fetchAllRowArray();
    }

    public function test_resultCount()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $return = $db->query($this->query)->resultCount();

        $this->assertTrue(
            $return > 1
        );
    }

    public function test_resultCount_exception()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->expectException(\Exception::class);

        $return = $db->resultCount();
    }

    public function test_serverHasTransaction()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection_test)
        );

        $this->assertTrue(
            $db->serverHasTransaction()
        );
    }

    public function test_beginTransaction_and_rollbackTransaction()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection_test)
        );

        $db->beginTransaction();

        $db->query(
            'INSERT INTO personas (nombre, edad) VALUES ("rollback", 27)'
        );

        $id = $db->fetchLastInsertId();

        $db->rollbackTransaction();

        $this->assertTrue(
            $db->getRow("SELECT * FROM personas WHERE id={$id}") === false
        );
    }

    public function test_resultExist()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->assertTrue(
            $db->resultExist() === false
        );

        $db->query($this->query);

        $this->assertTrue(
            $db->resultExist()
        );
    }

    public function test_clear()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->assertTrue(
            $db->clear()
        );

        $db->query($this->query);

        $this->assertTrue(
            $db->clear()
        );
    }

    public function test_beginTransaction_and_commitTransaction()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection_test)
        );

        $db->beginTransaction();

        $db->query(
            'INSERT INTO personas (nombre, edad) VALUES ("commit", 27)'
        );

        $id = $db->fetchLastInsertId();

        $db->commitTransaction();

        $return = $db->getRow("SELECT nombre, edad FROM personas WHERE id={$id}");

        $keys = ['nombre', 'edad'];

        foreach ($keys as $key) {
            $this->assertObjectHasAttribute(
                $key,
                $return
            );
        }
    }

    public function test_fetchLastInsertId()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection_test)
        );

        $db->beginTransaction();

        $db->query(
            'INSERT INTO personas (nombre, edad) VALUES ("fetchLastInsertId", 27)'
        );

        $id = $db->fetchLastInsertId();

        $return = $db->getRow("SELECT nombre, edad FROM personas WHERE id={$id}");

        $db->rollbackTransaction();

        $keys = ['nombre', 'edad'];

        foreach ($keys as $key) {
            $this->assertObjectHasAttribute(
                $key,
                $return
            );
        }
    }

    public function test_disconnect()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->assertTrue(
            $db->disconnect()
        );
    }

    public function test_useDB()
    {
        $db = new MYSQLDatabase(
            new DatabaseConnection($this->db_connection)
        );

        $this->assertTrue(
            $db->useDB('test')
        );

        $this->expectException(\Exception::class);

        $db->useDB('no_existe');
    }
}