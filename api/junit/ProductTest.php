<?php

require '../Product.php';
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase {
    private $db;
    private $host = "localhost";
    private $dbname = "db_cejasmy";
    private $username = "root";
    private $password = "";

    protected function setUp(): void {
        //$this->db = new DB($this->host, $this->dbname, $this->username, $this->password);
    }

    public function testCreateProduct() {
        $product = new Product($this->host, $this->dbname, $this->username, $this->password);
        $product->setPrice(25.99);
        $product->setName("Nuevo Producto");
        $product->setDescription("Descripción del nuevo producto");
        $result = $product->createProduct();
        $this->assertTrue($result);
    }

    public function testGetAllProducts() {
        $product = new Product($this->host, $this->dbname, $this->username, $this->password);
        $products = $product->getAllProducts();
        $this->assertIsArray($products);
    }

    public function testUpdateProduct() {
        $product = new Product($this->host, $this->dbname, $this->username, $this->password);
        $products = $product->getAllProducts();
        $productToUpdate = $products[0];
        $product->setIdProduct($productToUpdate['id_product']);
        $product->setPrice(29.99);
        $product->setName("Producto Actualizado");
        $product->setDescription("Nueva descripción del producto actualizado");
        $result = $product->updateProduct();
        $this->assertTrue($result);
    }

    public function testDeleteProduct() {
        $product = new Product($this->host, $this->dbname, $this->username, $this->password);
        $products = $product->getAllProducts();
        $productToDelete = $products[0];
        $product->setIdProduct($productToDelete['id_product']);
        $result = $product->deleteProduct();
        $this->assertTrue($result);
    }
}
