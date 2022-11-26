<?php

class DB
{
    private $db;

    public function __construct()
    {
        $dbinfo = require dirname(__DIR__, 1) . '/dbconnect.php';
        $this->db = new PDO('mysql:host=' . $dbinfo['host'] . ';dbname=' . $dbinfo['dbname'], $dbinfo['login'], $dbinfo['password']);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertQuery($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();
        return $this->db->lastInsertId();
    }



    public function getAll($table, $sql = '', $params = [])
    {
        return $this->query("SELECT * FROM $table " . $sql, $params);
    }
}
