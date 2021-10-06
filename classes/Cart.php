<?php
require_once "DbConnection.php";
include_once "Products.php";

class Cart extends DbConnection
{
    private $table;
    private $productObject;
    public function __construct()
    {
        parent::__construct();

        $this->table = "cart";

        $this->productObject = new Products();
    }

    public function findAll() {
        $select = $this->connection->prepare("SELECT *, cart.id AS cartID, products.id AS productId FROM {$this->table} INNER JOIN products ON cart.product_id = products.id");
        $select->execute();

        $data = [];

        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $data[] = (object) $row;
        }
        return $data;
    }

    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $publisher = $statement->fetch(PDO::FETCH_ASSOC);

        if ($publisher)
            return (object) $publisher;
        return false;
    }

    public function findByProductId($productId) {
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

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        if ($statement->execute())
            return true;
        return false;
    }

    public function updateBatch($data) {
        try {
            $this->connection->beginTransaction();

            $sql = "UPDATE {$this->table} SET quantity = :quantity, total_price= :total_price WHERE product_id = :product_id";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $statement->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $statement->bindParam(':total_price', $total_price, PDO::PARAM_BOOL);

            foreach ($data as $item) {
                $product_id = $item["productId"];
                $productPrice = $this->productObject->findById($product_id)->price;
                $quantity = $item["productQty"];
                $total_price = $productPrice * $quantity;

                $statement->execute();
            }
            $this->connection->commit();
            return true;
        }
        catch (PDOException $error) {
            $this->connection->rollBack();
            return false;
        }
    }
}