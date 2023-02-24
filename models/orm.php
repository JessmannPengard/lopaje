<?php

class Orm
{
    protected $id;
    protected $table;
    protected $dbconn;

    public function __construct($id, $table, $conn)
    {
        $this->id = $id;
        $this->table = $table;
        $this->dbconn = $conn;
    }

    public function getAll()
    {
        $stm = $this->dbconn->prepare("SELECT * FROM {$this->table}");
        $stm->execute();
        return $stm->fetchAll();
    }

    public function getById($id)
    {
        $stm = $this->dbconn->prepare("SELECT * FROM {$this->table} WHERE {$this->id}=:id");
        $stm->bindValue(":id", $id);
        $stm->execute();
        return $stm->fetch();
    }

    public function getAllButId($id)
    {
        $stm = $this->dbconn->prepare("SELECT * FROM {$this->table} WHERE {$this->id}!=:id");
        $stm->bindValue(":id", $id);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function deleteById($id)
    {
        $stm = $this->dbconn->prepare("DELETE FROM {$this->table} WHERE {$this->id}=:id");
        $stm->bindValue(":id", $id);
        $stm->execute();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} ";
        $keys = "(";
        $values = "VALUES (";

        foreach ($data as $key => $value) {
            $keys .= "{$key},";
            $values .= ":{$key},";
        }
        $keys = substr($keys, 0, -1) . ")";
        $values = substr($values, 0, -1) . ")";
        $sql .= $keys . $values;
        $stm = $this->dbconn->prepare($sql);
        foreach ($data as $key => $value) {
            $stm->bindValue(":{$key}", $value);
        }
        $stm->execute();
    }

    public function updateById($id, $data)
    {
        $sql = "UPDATE {$this->table} SET ";

        foreach ($data as $key => $value) {
            $sql .= "{$key}=:{$key},";
        }
        $sql = substr($sql, 0, -1);
        $sql .= " WHERE {$this->id}=:id";

        $stm = $this->dbconn->prepare($sql);
        foreach ($data as $key => $value) {
            $stm->bindValue(":{$key}", $value);
        }
        $stm->bindValue(":id", $id);
        $stm->execute();
    }
}