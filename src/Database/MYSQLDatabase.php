<?php
namespace Framework\Database;

class MYSQLDatabase extends Database
{
    protected $transactions_capable = false;

    public function connect()
    {
        $this->link = mysqli_connect($this->db_connection->host, $this->db_connection->user, $this->db_connection->pass);

        if (! $this->link) {
            throw new \Exception('No es posible contectarse a la base de datos. '. $this->getError());
        }

        $this->useDB($this->db_connection->database);

        if ($this->serverHasTransaction()) {
            $this->transactions_capable = true;
        }

        return $this;
    }

    public function query($sql, array $params = array())
    {
        if (! $this->link) {
            $this->connect();
        }

        $this->id_query = mysqli_query($this->link, $sql);

        if (! $this->id_query) {
            if ($this->begin_transaction) {
                $this->rollbackTransaction();
            }

            throw new \Exception('Query inválida. '. $this->getError());
        }

        return $this;
    }

    protected function getError()
    {
        if (! $this->link) {
            return '';
        }

        return '['. mysqli_errno($this->link). ': '. mysqli_error($this->link). ']';
    }

    public function fetchRow()
    {
        $this->isIdQuery();

        return mysqli_fetch_object($this->id_query);
    }

    public function getRow($query, Array $params = array())
    {
        return $this->query($query, $params)->fetchRow();
    }

    public function fetchRowArray()
    {
        $this->isIdQuery();

        return mysqli_fetch_array($this->id_query);
    }

    public function isIdQuery($throw_exception = true)
    {
        if (! isset($this->id_query)) {
            if ($throw_exception) {
                throw new \Exception('Query no especificado.');
            }

            return false;
        }

        return true;
    }

    public function fetchAllRow()
    {
        $all_row = array();

        while ($row = $this->fetchRow()) {
            $all_row[] = $row;
        }

        return $all_row;
    }

    public function fetchAllRowArray()
    {
        $all_row = array();

        while ($row = $this->fetchRowArray()) {
            $all_row[] = $row;
        }

        return $all_row;
    }

    public function resultCount()
    {
        $this->isIdQuery();

        if (($n = mysqli_num_rows($this->id_query)) === false) {
            throw new \Exception('No es posible contar las filas. '. $this->getError());
        }

        return $n;
    }

    public function beginTransaction()
    {
        if (! $this->transactions_capable) {
            throw new \Exception('El servidor no soporta Commit y Rollback');
        }

        if (! $this->begin_transaction) {
            $this->query('BEGIN');
            $this->begin_transaction = true;
        }
    }

    public function serverHasTransaction()
    {
        $this->query('SHOW ENGINES');

        if ($this->resultExist()) {
            while ($row = $this->fetchRowArray()) {
                // InnoDB soporta transacciones PERO las tablas tienen que estar con InnoDB porque sino, no funciona
                if ($row['Engine'] == 'InnoDB' && ($row['Support'] == 'YES' || $row['Support'] == 'DEFAULT')) {
                    $this->transactions_capable = true;
                    break;
                }
            }
        }

        $this->clear();
        return $this->transactions_capable;
    }

    public function resultExist()
    {
        if ($this->isIdQuery(false) && ($this->resultCount() > 0)) {
            return true;
        }

        return false;
    }

    public function clear()
    {
        if ($this->isIdQuery(false) && ! mysqli_free_result($this->id_query)) {
            return false;
        }

        unset($this->id_query);
        return true;
    }

    public function rollbackTransaction()
    {
        if ($this->transactions_capable && $this->begin_transaction) {
            $this->query('ROLLBACK');
            $this->begin_transaction = false;
        }
    }

    public function commitTransaction()
    {
        if ($this->transactions_capable && $this->begin_transaction) {
            $this->query('COMMIT');
            $this->begin_transaction = false;
        }
    }

    public function fetchLastInsertId()
    {
        if (! $this->link) {
            return false;
        }

        return mysqli_insert_id($this->link);
    }

    public function disconnect()
    {
        if (! $this->link) {
            return true;
        }

        if (mysqli_close($this->link)) {
            unset($this->link);
            return true;
        }

        return false;
    }

    public function useDB($database)
    {
        if (! mysqli_select_db($this->link, $database)) {
            throw new \Exception('No es posible cambiar la base de datos. '. $this->getError());
        }

        $this->db_connection->database = $database;

        return true;
    }
}
