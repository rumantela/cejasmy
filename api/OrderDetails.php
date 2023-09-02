<?php

class OrderDetails {
    private $conn;
    private $id_order_details;
    private $id_order;
    private $id_product;

    public function __construct($host, $dbname, $username, $password) {
        
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $this->conn = new PDO($dsn, $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Setters
    public function setIdOrderDetails($id_order_details) {
        $this->id_order_details = $id_order_details;
    }

    public function setIdOrder($id_order) {
        $this->id_order = $id_order;
    }

    public function setIdProduct($id_product) {
        $this->id_product = $id_product;
    }

    // Getters
    public function getIdOrderDetails() {
        return $this->id_order_details;
    }

    public function getIdOrder() {
        return $this->id_order;
    }

    public function getIdProduct() {
        return $this->id_product;
    }

    public function createOrderDetails() {
        $sql = "INSERT INTO order_details (id_order, id_product) VALUES (:id_order, :id_product)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_order', $this->id_order, PDO::PARAM_INT);
        $stmt->bindParam(':id_product', $this->id_product, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllOrderDetails() {
        $sql = "SELECT * FROM order_details";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderDetails() {
        $sql = "UPDATE order_details SET id_order = :id_order, id_product = :id_product WHERE id_order_details = :id_order_details";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_order', $this->id_order, PDO::PARAM_INT);
        $stmt->bindParam(':id_product', $this->id_product, PDO::PARAM_INT);
        $stmt->bindParam(':id_order_details', $this->id_order_details, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteOrderDetails() {
        $sql = "DELETE FROM order_details WHERE id_order_details = :id_order_details";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_order_details', $this->id_order_details, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
