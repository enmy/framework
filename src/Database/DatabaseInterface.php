<?php
namespace Framework\Database;

interface DatabaseInterface {
    public function query($query, Array $params = array());
    public function connect();
    public function disconnect();
    public function fetchRow();
    public function fetchAllRow();
    public function fetchObj();
    public function fetchLastInsertId();
    public function resultCount();
    public function beginTransaction();
    public function commitTransaction();
    public function rollbackTransaction();
}