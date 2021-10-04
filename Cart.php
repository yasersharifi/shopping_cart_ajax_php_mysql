<?php
require_once "DbConnection.php";

class Cart extends DbConnection
{
    private $table;
    public function __construct()
    {
        parent::__construct();

        $this->table = "cart";
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

    public function getByProductId($productId) {
        $sql = "SELECT * FROM {$this->table} WHERE product_id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":id", $productId, PDO::PARAM_INT);
        $statement->execute();
        $publisher = $statement->fetch(PDO::FETCH_ASSOC);

        if ($publisher)
            return (object) $publisher;
        return false;
    }

    public function countCart() {
        $select = $this->connection->prepare("SELECT COUNT(id) AS count FROM {$this->table} GROUP BY product_id");
        $select->execute();

        $data = [];

        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $data[] = (object) $row;
        }
        return count($data);
    }

    public function insert($productId, $quantity, $totalPrice) {
        $sql = "INSERT INTO {$this->table} (product_id, 
                   quantity,
                   total_price) VALUES (:productId,
                                         :quantity,
                                         :totalPrice)";

        $insert = $this->connection->prepare($sql);

        try {
            $this->connection->beginTransaction();

            $insert->bindParam(":productId", $productId);
            $insert->bindParam(":quantity", $quantity);
            $insert->bindParam(":totalPrice", $totalPrice);

            $insert->execute();

            $this->connection->commit();
            return true;
        }
        catch (PDOException $error) {
            return false;
        }
    }
}