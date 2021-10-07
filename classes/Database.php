<?php
require_once "DbConnection.php";;

class Database extends DbConnection
{
    public $table;
    public function __construct()
    {
        parent::__construct();
    }

    public function get($query) {
        $query = "SELECT {$query} FROM {$this->table}";
        $select = $this->connection->prepare($query);
        $select->execute();

        $data = [];

        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $data[] = (object) $row;
        }
        return $data;
    }

    public function find($column) {
        $key = array_key_first($column);
        $value = $column[$key];

        $query = "SELECT * FROM {$this->table} WHERE {$key} = :{$key}";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":{$key}", $value, PDO::PARAM_INT);
        $statement->execute();
        $publisher = $statement->fetch(PDO::FETCH_ASSOC);

        if ($publisher)
            return (object) $publisher;
        return false;
    }

    public function insert($data) {
        $dataKeys = implode(", ", array_keys($data));
        $dataKeysWithPrefix = [];
        foreach (array_keys($data) as $value) {
            $dataKeysWithPrefix[] = ":" . $value;
        }
        $dataKeysWithPrefixImplode = implode(", ", $dataKeysWithPrefix);

        $query = "INSERT INTO {$this->table} ($dataKeys) VALUES ($dataKeysWithPrefixImplode)";

        $insert = $this->connection->prepare($query);

        try {
            $this->connection->beginTransaction();

            foreach ($data as $key => $value) {
                $insert->bindParam(":{$key}", $value);
            }

            $insert->execute();

            $this->connection->commit();
            return true;
        }
        catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function delete($where) {
        if ($this->where($where) == false) {
            return false;
        }

        $key = array_key_first($where);
        $value = $where[$key];

        $sql = "DELETE FROM {$this->table} WHERE {$key} = :{$key}";
        $statement = $this->connection->prepare($sql);

        $statement->bindParam(":{$key}", $value, PDO::PARAM_INT);

        if ($statement->execute())
            return true;
        return false;
    }

    public function where($where) {
        $key = array_key_first($where);
        $value = $where[$key];

        $query = "SELECT * FROM {$this->table} WHERE {$key} = :{$key}";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(":{$key}", $value);
        $statement->execute();
        $publisher = $statement->fetch(PDO::FETCH_ASSOC);

        if ($publisher)
            return true;
        return false;

    }

}