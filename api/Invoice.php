<?php
class Invoice {
    private $conn;
    private $table_name = "invoices";

    public $id_invoice;
    public $id_product;
    public $id_customer;
    public $id_guest;
    public $price;
    public $tax;
    public $ref;
    public $date_add;
    public $date_upd;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Setter y Getter para id_invoice
    public function getIdInvoice() {
        return $this->id_invoice;
    }

    public function setIdInvoice($id_invoice) {
        $this->id_invoice = $id_invoice;
    }

    // Setter y Getter para id_product
    public function getIdProduct() {
        return $this->id_product;
    }

    public function setIdProduct($id_product) {
        $this->id_product = $id_product;
    }

    // Setter y Getter para id_customer
    public function getIdCustomer() {
        return $this->id_customer;
    }

    public function setIdCustomer($id_customer) {
        $this->id_customer = $id_customer;
    }

    // Setter y Getter para id_guest
    public function getIdGuest() {
        return $this->id_guest;
    }

    public function setIdGuest($id_guest) {
        $this->id_guest = $id_guest;
    }

    // Setter y Getter para price
    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    // Setter y Getter para tax
    public function getTax() {
        return $this->tax;
    }

    public function setTax($tax) {
        $this->tax = $tax;
    }

    // Setter y Getter para ref
    public function getRef() {
        return $this->ref;
    }

    public function setRef($ref) {
        $this->ref = $ref;
    }

    // Setter y Getter para date_add
    public function getDateAdd() {
        return $this->date_add;
    }

    public function setDateAdd($date_add) {
        $this->date_add = $date_add;
    }

    // Setter y Getter para date_upd
    public function getDateUpd() {
        return $this->date_upd;
    }

    public function setDateUpd($date_upd) {
        $this->date_upd = $date_upd;
    }

    // Crear un nuevo registro de factura
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET id_product = :id_product, id_customer = :id_customer, id_guest = :id_guest, 
                      price = :price, tax = :tax, ref = :ref";

        $stmt = $this->conn->prepare($query);

        // Limpia y asegura los datos antes de la inserción
        $this->id_product = htmlspecialchars(strip_tags($this->id_product));
        $this->id_customer = htmlspecialchars(strip_tags($this->id_customer));
        $this->id_guest = htmlspecialchars(strip_tags($this->id_guest));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->tax = htmlspecialchars(strip_tags($this->tax));
        $this->ref = htmlspecialchars(strip_tags($this->ref));

        // Bind los parámetros
        $stmt->bindParam(":id_product", $this->id_product);
        $stmt->bindParam(":id_customer", $this->id_customer);
        $stmt->bindParam(":id_guest", $this->id_guest);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":tax", $this->tax);
        $stmt->bindParam(":ref", $this->ref);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer una factura por su ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_invoice = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_invoice);
        $stmt->execute();
        return $stmt;
    }

    // Leer todas las facturas
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name ." i INNER JOIN customers c ON c.id_customer=i.id_customer
            INNER JOIN products p ON i.id_product=p.id_product
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Actualizar una factura
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET id_product = :id_product, id_customer = :id_customer, id_guest = :id_guest, 
                      price = :price, tax = :tax, ref = :ref
                  WHERE id_invoice = :id_invoice";

        $stmt = $this->conn->prepare($query);

        // Limpia y asegura los datos antes de la actualización
        $this->id_product = htmlspecialchars(strip_tags($this->id_product));
        $this->id_customer = htmlspecialchars(strip_tags($this->id_customer));
        $this->id_guest = htmlspecialchars(strip_tags($this->id_guest));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->tax = htmlspecialchars(strip_tags($this->tax));
        $this->ref = htmlspecialchars(strip_tags($this->ref));
        $this->id_invoice = htmlspecialchars(strip_tags($this->id_invoice));

        // Bind los parámetros
        $stmt->bindParam(":id_product", $this->id_product);
        $stmt->bindParam(":id_customer", $this->id_customer);
        $stmt->bindParam(":id_guest", $this->id_guest);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":tax", $this->tax);
        $stmt->bindParam(":ref", $this->ref);
        $stmt->bindParam(":id_invoice", $this->id_invoice);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Borrar una factura
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_invoice = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_invoice);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
