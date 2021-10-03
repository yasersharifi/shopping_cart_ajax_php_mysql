<?php
require_once "DbConnection.php";

class Products extends DbConnection
{
    private $table;
    public function __construct()
    {
        parent::__construct();

        $this->table = "products";
    }

    public function get() {
        $select = $this->connection->prepare("SELECT * FROM {$this->table}");
        $select->execute();

        $data = [];

        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $data[] = (object) $row;
        }
        return $data;
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $publisher = $statement->fetch(PDO::FETCH_ASSOC);

        if ($publisher)
            return (object) $publisher;
        return false;
    }
}