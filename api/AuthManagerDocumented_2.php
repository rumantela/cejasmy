<?php

class AuthManager {
  private $db;
  private $connectionStatus;

  /**
   * Constructor de la clase. Establece la conexión con la base de datos.
   */
  public function __construct() {
    // Conexión a la base de datos (ajusta estos valores según tu configuración)
    $servername = "localhost";
    $username = "tu_usuario_db";
    $password = "tu_contraseña_db";
    $dbname = "tu_base_de_datos";

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

  /**
   * Método para registrar un nuevo usuario.
   *
   * @param string $nombreUsuario El nombre de usuario del nuevo usuario.
   * @param string $contrasena La contraseña del nuevo usuario.
   * @return string Respuesta en formato JSON que indica si el registro fue exitoso o no.
   */
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
      return $this->responseJson(true, "Usuario registrado exitosamente.");
    } else {
      return $this->responseJson(false, "Error al registrar el usuario.");
    }
  }

  /**
   * Método para autenticar un usuario.
   *
   * @param string $nombreUsuario El nombre de usuario del usuario a autenticar.
   * @param string $contrasena La contraseña del usuario a autenticar.
   * @return string Respuesta en formato JSON que indica si la autenticación fue exitosa o no.
   */
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
      return $this->responseJson(true, "Usuario autenticado exitosamente.", $userData);
    } else {
      return $this->responseJson(false, "Credenciales inválidas.");
    }
  }

  /**
   * Método para cerrar la conexión a la base de datos.
   */
  public function __destruct() {
    $this->db->close();
  }

  /**
   * Método para generar una respuesta en formato JSON.
   *
   * @param bool $success Indica si la operación fue exitosa o no.
   * @param string $message El mensaje descriptivo de la operación.
   * @param array|null $data Datos adicionales a incluir en la respuesta JSON (opcional).
   * @return string Respuesta en formato JSON con los detalles de la operación.
   */
  private function responseJson($success, $message, $data = null) {
    $response = array(
      "success" => $success,
      "message" => $message
    );

    if ($data !== null) {
      $response["data"] = $data;
    }

    return json_encode($response);
  }

  // Resto de métodos...
}
