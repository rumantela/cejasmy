<?php
class ProductComment {
    private $conn;

    public function __construct($host, $dbname, $username, $password) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $this->conn = new PDO($dsn, $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Crear un nuevo comentario de producto
    public function create($id_product, $id_customer, $id_guest, $title, $content, $customer_name, $grade, $validate) {
        $query = "INSERT INTO product_comment (id_product, id_customer, id_guest, title, content, customer_name, grade, validate, deleted) 
                  VALUES (:id_product, :id_customer, :id_guest, :title, :content, :customer_name, :grade, :validate, 0)";
        
        $stmt = $this->conn->prepare($query);

        // Limpia y asegura los datos antes de la inserción
        $id_product = htmlspecialchars(strip_tags($id_product));
        $id_customer = htmlspecialchars(strip_tags($id_customer));
        $id_guest = htmlspecialchars(strip_tags($id_guest));
        $title = htmlspecialchars(strip_tags($title));
        $content = htmlspecialchars(strip_tags($content));
        $customer_name = htmlspecialchars(strip_tags($customer_name));
        $grade = floatval($grade);
        $validate = intval($validate);

        // Bind los parámetros
        $stmt->bindParam(":id_product", $id_product);
        $stmt->bindParam(":id_customer", $id_customer);
        $stmt->bindParam(":id_guest", $id_guest);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":customer_name", $customer_name);
        $stmt->bindParam(":grade", $grade);
        $stmt->bindParam(":validate", $validate);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer un comentario de producto por su ID
    public function readOne($id) {
        $query = "SELECT * FROM product_comment WHERE id_product_comment = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }

    // Leer todos los comentarios de producto
    public function readAll() {
        $query = "SELECT * FROM product_comment pc INNER JOIN products p ON pc.id_product=p.Id_product
            INNER JOIN customers c ON c.id_customer=pc.id_customer
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Actualizar un comentario de producto
    public function update($id_product_comment, $title, $content, $grade, $validate) {
        $query = "UPDATE product_comment 
                  SET title = :title, content = :content, grade = :grade, validate = :validate
                  WHERE id_product_comment = :id_product_comment";
        
        $stmt = $this->conn->prepare($query);

        // Limpia y asegura los datos antes de la actualización
        $title = htmlspecialchars(strip_tags($title));
        $content = htmlspecialchars(strip_tags($content));
        $grade = floatval($grade);
        $validate = intval($validate);
        $id_product_comment = intval($id_product_comment);

        // Bind los parámetros
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":grade", $grade);
        $stmt->bindParam(":validate", $validate);
        $stmt->bindParam(":id_product_comment", $id_product_comment);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Borrar un comentario de producto
    public function delete($id) {
        $query = "UPDATE product_comment SET deleted = 1 WHERE id_product_comment = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
