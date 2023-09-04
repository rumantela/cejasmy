<?php

class Order {
    private $conn;
    private $id_order;
    private $id_customer;
    private $amount;
    private $created;
    private $ref;
    private $id_cart;

    public function __construct($host, $dbname, $username, $password) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $this->conn = new PDO($dsn, $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Setters
    public function setIdOrder($id_order) {
        $this->id_order = $id_order;
    }

    public function setIdCustomer($id_customer) {
        $this->id_customer = $id_customer;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }
    public function setCreated($created) {
        $this->created = $created;
    }

    public function setRef($ref){
        $this->ref = $ref;
    }

    public function setIdCart($id_cart){
        $this->id_cart = $id_cart;
    }
    // Getters
    public function getIdOrder() {
        return $this->id_order;
    }

    public function getIdCustomer() {
        return $this->id_customer;
    }

    public function getAmount() {
        return $this->amount;
    }


    public function getCreated() {
        return $this->created;
    }

    public function getRef(){
        return $this->ref;
    }
    public function getIdCart(){
        return $this->id_cart;
    }

    public function getOrderDetails() {
        $sql = "SELECT * FROM order_details WHERE id_order = :id_order";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_order', $this->id_order, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function createOrder() {
        $sql = "INSERT INTO orders (id_customer,amount,id_cart,ref) VALUES (:id_customer,:amount,:id_cart,:ref)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_customer', $this->id_customer, PDO::PARAM_INT);
        $stmt->bindParam(':id_cart', $this->id_cart, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $this->amount, PDO::PARAM_STR);
        $stmt->bindParam(':ref', $this->ref, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getAllOrders() {
        $sql = "SELECT o.*, p.*, c.* FROM orders o INNER JOIN order_details od ON od.id_order=o.id_order
            INNER JOIN products p ON p.id_product=od.id_product
            INNER JOIN customers c ON c.id_customer=o.id_customer
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrder() {
        $sql = "UPDATE orders SET id_customer = :id_customer, amount = :amount WHERE id_order = :id_order";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_customer', $this->id_customer, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':id_order', $this->id_order, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteOrder() {
        $sql = "DELETE FROM orders WHERE id_order = :id_order";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_order', $this->id_order, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
