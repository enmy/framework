<?php
namespace Framework\Database;

class MYSQLDatabase extends Database
{
    public function connect()
    {
        $this->link = @mysql_connect($this->db_connection->host, $this->db_connection->user, $this->db_connection->pass);

        if (! $this->link) {
            throw new \Exception('No es posible contectarse a la base de datos.'. $this->getError());
        }

        if (! mysql_select_db($this->db_connection->database, $this->link)) {
            throw new \Exception('No es posible cambiar la base de datos.'. $this->getError());
        }

        return $this;
    }

    public function query($sql, array $params = array())
    {
        if (empty($this->link)) {
            $this->connect();
        }

        $this->id_query = mysql_query($sql, $this->link);

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

        return '['. mysql_errno($this->link). ': '. mysql_error($this->link). ']';
    }

    public function fetchRow()
    {
        if (!isset($this->id_query)) {
            throw new \Exception('Query no especificado.');
        }

        return mysql_fetch_array($this->id_query);
    }

    public function getRow($query, Array $params = array())
    {
        return $this->query($query, $params)->fetchRow();
    }

    public function disconnect(){}
    public function fetchAllRow(){}
    public function fetchObj(){}
    public function fetchLastInsertId(){}
    public function resultCount(){}
    public function beginTransaction(){}
    public function commitTransaction(){}
    public function rollbackTransaction(){}
}