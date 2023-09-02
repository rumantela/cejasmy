<?php

class Product {
    private $conn;
    private $id_product;
    private $price;
    private $name;
    private $description;

    public function __construct($host, $dbname, $username, $password) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $this->conn = new PDO($dsn, $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Setters
    public function setIdProduct($id_product) {
        $this->id_product = $id_product;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    // Getters
    public function getIdProduct() {
        return $this->id_product;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function createProduct() {
        $sql = "INSERT INTO products (price, name, description) VALUES (:price, :name, :description)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProduct() {
        $sql = "UPDATE products SET price = :price, name = :name, description = :description WHERE id_product = :id_product";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':id_product', $this->id_product, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteProduct() {
        $sql = "DELETE FROM products WHERE id_product = :id_product";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_product', $this->id_product, PDO::PARAM_INT);
        return $stmt->execute();
    }
}



