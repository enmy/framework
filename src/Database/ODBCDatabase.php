<?php
namespace Framework\Database;

class ODBCDatabase extends Database
{
    public function query($sql, array $params = array())
    {
        if (! $this->link) {
            $this->connect();
        }

        $this->id_query = odbc_exec($this->link, $sql);

        if (! $this->id_query) {
            throw new \Exception('Query inválida. '. $this->getError());
        }

        return $this;
    }

    public function connect()
    {
        $this->link = odbc_connect($this->db_connection->host, $this->db_connection->user, $this->db_connection->pass);

        if (! $this->link) {
            throw new \Exception('No es posible contectarse a la base de datos. '. $this->getError());
        }

        return $this;
    }

    public function fetchRow()
    {
        $this->isIdQuery();

        return odbc_fetch_object($this->id_query);
    }

    public function fetchAllRow()
    {
        $all_row = array();

        while ($row = $this->fetchRow()) {
            $all_row[] = $row;
        }

        return $all_row;
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

    public function getError()
    {
        if (! $this->link) {
            return '';
        }

        return '['. odbc_error($this->link). ': '. odbc_errormsg($this->link). ']';
    }

    public function getRow($query, Array $params = array())
    {
        return $this->query($query, $params)->fetchRow();
    }

    public function disconnect(){}
    public function fetchRowArray(){}
    public function fetchAllRowArray(){}
    public function fetchLastInsertId(){}
    public function resultCount(){}
    public function beginTransaction(){}
    public function commitTransaction(){}
    public function rollbackTransaction(){}
}
