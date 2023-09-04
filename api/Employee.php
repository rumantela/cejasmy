<?php
class Employee {
    private $conn;

    public function __construct($host, $dbname, $username, $password) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $this->conn = new PDO($dsn, $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Crear un nuevo empleado
    public function create($firstname, $lastname, $email, $password, $birthday, $active) {
        $query = "INSERT INTO employees (firstname, lastname, email, password, birthday, active, deleted) 
                  VALUES (:firstname, :lastname, :email, :password, :birthday, :active, 0)";
        
        $stmt = $this->conn->prepare($query);

        // Limpia y asegura los datos antes de la inserción
        $firstname = htmlspecialchars(strip_tags($firstname));
        $lastname = htmlspecialchars(strip_tags($lastname));
        $email = htmlspecialchars(strip_tags($email));
        $password = password_hash($password, PASSWORD_DEFAULT); // Hashear la contraseña
        $birthday = htmlspecialchars(strip_tags($birthday));
        $active = intval($active);

        // Bind los parámetros
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":birthday", $birthday);
        $stmt->bindParam(":active", $active);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer un empleado por su ID
    public function readOne($id) {
        $query = "SELECT * FROM employees WHERE id_employee = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }

    // Leer todos los empleados
    public function readAll() {
        $query = "SELECT * FROM employees";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Actualizar un empleado
    public function update($id_employee, $firstname, $lastname, $email, $password, $birthday, $active) {
        $query = "UPDATE employees 
                  SET firstname = :firstname, lastname = :lastname, email = :email, password = :password, 
                  birthday = :birthday, active = :active
                  WHERE id_employee = :id_employee";
        
        $stmt = $this->conn->prepare($query);

        // Limpia y asegura los datos antes de la actualización
        $firstname = htmlspecialchars(strip_tags($firstname));
        $lastname = htmlspecialchars(strip_tags($lastname));
        $email = htmlspecialchars(strip_tags($email));
        $password = password_hash($password, PASSWORD_DEFAULT); // Hashear la contraseña
        $birthday = htmlspecialchars(strip_tags($birthday));
        $active = intval($active);
        $id_employee = intval($id_employee);

        // Bind los parámetros
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":birthday", $birthday);
        $stmt->bindParam(":active", $active);
        $stmt->bindParam(":id_employee", $id_employee);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Borrar un empleado
    public function delete($id) {
        $query = "UPDATE employees SET deleted = 1 WHERE id_employee = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
