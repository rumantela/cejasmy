<?php
require '../DB.php';
require '../OrderDetails.php';
use PHPUnit\Framework\TestCase;

class OrderDetailsTest extends TestCase {
    private $db;
    private $host = "1247.0.0.0";
    private $dbname = "db_name";
    private $username = "root";
    private $password = "";

    protected function setUp(): void {
        $this->db = new DB($this->host, $this->dbname, $this->username, $this->password);
    }

    public function testCreateOrderDetails() {
        $orderDetails = new OrderDetails($this->host, $this->dbname, $this->username, $this->password);
        $orderDetails->setIdOrder(1);
        $orderDetails->setIdProduct(1);
        $result = $orderDetails->createOrderDetails();
        $this->assertTrue($result);
    }

    public function testGetAllOrderDetails() {
        $orderDetails = new OrderDetails($this->host, $this->dbname, $this->username, $this->password);
        $orderDetailsList = $orderDetails->getAllOrderDetails();
        $this->assertIsArray($orderDetailsList);
    }

    public function testUpdateOrderDetails() {
        $orderDetails = new OrderDetails($this->host, $this->dbname, $this->username, $this->password);
        $orderDetailsList = $orderDetails->getAllOrderDetails();
        $orderDetailsToUpdate = $orderDetailsList[0];
        $orderDetails->setIdOrderDetails($orderDetailsToUpdate['id_order_details']);
        $orderDetails->setIdOrder(2);
        $orderDetails->setIdProduct(2);
        $result = $orderDetails->updateOrderDetails();
        $this->assertTrue($result);
    }

    public function testDeleteOrderDetails() {
        $orderDetails = new OrderDetails($this->host, $this->dbname, $this->username, $this->password);
        $orderDetailsList = $orderDetails->getAllOrderDetails();
        $orderDetailsToDelete = $orderDetailsList[0];
        $orderDetails->setIdOrderDetails($orderDetailsToDelete['id_order_details']);
        $result = $orderDetails->deleteOrderDetails();
        $this->assertTrue($result);
    }



    public function testGetOrderDetails() {
        $order = new Order($this->host, $this->dbname, $this->username, $this->password);
        $order->setIdCustomer(1);
        $order->createOrder();

        $orderDetails = new OrderDetails($this->host, $this->dbname, $this->username, $this->password);
        $orderDetails->setIdOrder($order->getIdOrder());
        $orderDetails->setIdProduct(1);
        $orderDetails->createOrderDetails();

        $orderDetailsList = $order->getOrderDetails();
        $this->assertIsArray($orderDetailsList);
    }
}

