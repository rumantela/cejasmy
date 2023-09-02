<?php



class AuthManager {
  private $db;




  
    
    private $connectionStatus;
  
    public function __construct($db_connection) {
      // Conexión a la base de datos (ajusta estos valores según tu configuración)
      $servername = $db_connection['db_server'];
      $username = $db_connection['db_user'];
      $password = $db_connection['db_password'];
      $dbname = $db_connection['db_name'];
  
      // Creamos la conexión
      $this->db = new mysqli($servername, $username, $password, $dbname);
  
      // Verificar el estado de la conexión
      if ($this->db->connect_error) {
        $this->connectionStatus = array(
          "success" => false,
          "message" => "Error de conexión: " . $this->db->connect_error
        );
      } else {
        $this->connectionStatus = array(
          "success" => true,
          "message" => "Conexión exitosa a la base de datos."
        );
      }
    }
  
    // Método para generar una respuesta en formato JSON
    /*private function responseJson($success, $message, $data = null) {
      $response = array(
        "success" => $success,
        "message" => $message
      );
  
      if ($data !== null) {
        $response["data"] = $data;
      }
  
      return json_encode($response);
    }
    */
  
    // Método para registrar un nuevo usuario
    public function registerUser($nombreUsuario, $contrasena) {
      // Validar datos para prevenir inyección SQL
      $nombreUsuario = $this->sanitizeData($nombreUsuario);
      $contrasena = $this->sanitizeData($contrasena);
  
      // Generar un salt aleatorio para agregar seguridad adicional
      $salt = $this->generateSalt();
      $contrasenaHashed = $this->hashPassword($contrasena, $salt);
  
      $stmt = $this->db->prepare("INSERT INTO users (nombreUsuario, contrasena, salt) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $nombreUsuario, $contrasenaHashed, $salt);
  
      if ($stmt->execute()) {
        return true; //$this->responseJson(true, "Usuario registrado exitosamente.");
      } else {
        return false; //$this->responseJson(false, "Error al registrar el usuario.");
      }
    }
  
    // Método para autenticar un usuario
    public function authenticateUser($nombreUsuario, $contrasena) {
      // Validar datos para prevenir inyección SQL
      $nombreUsuario = $this->sanitizeData($nombreUsuario);
      $contrasena = $this->sanitizeData($contrasena);
  
      // Obtener información del usuario de la base de datos
      $stmt = $this->db->prepare("SELECT id, nombreUsuario, contrasena, salt FROM users WHERE nombreUsuario = ?");
      $stmt->bind_param("s", $nombreUsuario);
      $stmt->execute();
      $stmt->bind_result($id, $nombreUsuario, $contrasenaHashed, $salt);
      $stmt->fetch();
  
      // Verificar si el usuario existe y las credenciales son correctas
      if ($id && $this->verifyPassword($contrasena, $contrasenaHashed, $salt)) {
        $userData = array(
          "user_id" => $id,
          "nombreUsuario" => $nombreUsuario
        );
        return true;      //$this->responseJson(true, "Usuario autenticado exitosamente.", $userData);
      } else {
        return false;     //$this->responseJson(false, "Credenciales inválidas.");
      }
    }
    public function authenticateEmployee($nombreUsuario, $contrasena) {
      // Validar datos para prevenir inyección SQL
      $nombreUsuario = $this->sanitizeData($nombreUsuario);
      $contrasena = $this->sanitizeData($contrasena);
  
      // Obtener información del usuario de la base de datos
      $stmt = $this->db->prepare("SELECT u.id, u.nombreUsuario, u.contrasena, u.salt FROM users u INNER JOIN employees e ON u.nombreUsuario=e.email  WHERE nombreUsuario = ?");
      $stmt->bind_param("s", $nombreUsuario);
      $stmt->execute();
      $stmt->bind_result($id, $nombreUsuario, $contrasenaHashed, $salt);
      $stmt->fetch();
      //var_dump($this->verifyPassword($contrasena, $contrasenaHashed, $salt));
      // Verificar si el usuario existe y las credenciales son correctas
      if ($id && $this->verifyPassword($contrasena, $contrasenaHashed, $salt)) {
        $userData = array(
          "user_id" => $id,
          "nombreUsuario" => $nombreUsuario
        );
        return true; //$this->responseJson(true, "Usuario autenticado exitosamente.", $userData);
      } else {
        return false; //$this->responseJson(false, "Credenciales inválidas.");
      }
    }
    public function getHashPassword($password){
      return hash("sha256", $password . $this->generateSalt());
    }
  public function resetPassword($password,$email){
    // Validar datos para prevenir inyección SQL
    $contrasena = $this->sanitizeData($password);

    // Generar un salt aleatorio para agregar seguridad adicional
    $salt = $this->generateSalt();
    $contrasenaHashed = $this->hashPassword($contrasena, $salt);

    $stmt = $this->db->prepare("UPDATE users VALUES password=:password,salt=:salt,reset_key WHERE email=:email");
    $stmt->bind_param("ssss", $contrasenaHashed, $salt, "",$email);

    if ($stmt->execute()) {
      return true; //$this->responseJson(true, "Usuario registrado exitosamente.");
    } else {
      return false; //$this->responseJson(false, "Error al registrar el usuario.");
    }
  }

  // Función para limpiar y validar datos ingresados por el usuario
  private function sanitizeData($data) {
    // Eliminar caracteres especiales
    $data = htmlspecialchars($data);
    // Limpiar espacios en blanco
    $data = trim($data);
    // Escapar caracteres peligrosos para prevenir inyección SQL
    $data = $this->db->real_escape_string($data);

    return $data;
  }

  // Función para generar un salt aleatorio
  private function generateSalt() {
    return base64_encode(random_bytes(32));
  }

  // Función para generar un hash de contraseña usando el salt
  private function hashPassword($password, $salt) {
    $hash = hash("sha256", $password . $salt);
    //var_dump($hash);
    return $hash;
    //return hash("sha256", $password . $salt);
  }

  // Función para verificar la contraseña ingresada con el hash almacenado en la base de datos
  private function verifyPassword($password, $contrasenaHashed, $salt) {
    //var_dump($contrasenaHashed);
    return $contrasenaHashed === $this->hashPassword($password, $salt);
  }

  // Cerrar la conexión a la base de datos
  public function __destruct() {
    $this->db->close();
  }
}