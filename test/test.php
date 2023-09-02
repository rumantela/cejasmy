<?php

// Función para generar archivos PHP con las clases de las tablas
function generateClassesFromSQL($sql) {
  // Utilizamos expresiones regulares para extraer las definiciones de las tablas
  preg_match_all('/CREATE TABLE `db_cejasmy`.`(\w+)` \((.+?)\);/si', $sql, $matches, PREG_SET_ORDER);

  // Generamos una clase PHP para cada tabla encontrada
  foreach ($matches as $match) {
    $tableName = $match[1];
    $tableFields = $match[2];

    // Procesamos los campos de la tabla para obtener sus nombres y tipos
    preg_match_all('/`(\w+)`\s+([^,]+)/', $tableFields, $fieldMatches, PREG_SET_ORDER);

    $fieldNames = array();
    $fieldTypes = array();

    foreach ($fieldMatches as $fieldMatch) {
      $fieldName = $fieldMatch[1];
      $fieldType = $fieldMatch[2];
      $fieldNames[] = $fieldName;
      $fieldTypes[] = $fieldType;
    }

    // Generamos la clase PHP para la tabla
    generateClassFile($tableName, $fieldNames, $fieldTypes);
  }
}

// Función para generar el archivo PHP con la clase de la tabla
function generateClassFile($tableName, $fieldNames, $fieldTypes) {
  // Contenido de la clase
  $classContent = "<?php\n\nclass $tableName {\n";

  // Generamos las propiedades de la clase según los campos de la tabla
  foreach ($fieldNames as $index => $fieldName) {
    $fieldType = $fieldTypes[$index];
    $classContent .= "  private \$$fieldName;\n";
  }

  // Generamos el constructor de la clase
  $classContent .= "\n  public function __construct(\$data) {\n";
  foreach ($fieldNames as $fieldName) {
    $classContent .= "    \$this->$fieldName = \$data['$fieldName'];\n";
  }
  $classContent .= "  }\n";

  // Generamos los getters de la clase
  foreach ($fieldNames as $fieldName) {
    $classContent .= "\n  public function get$fieldName() {\n";
    $classContent .= "    return \$this->$fieldName;\n";
    $classContent .= "  }\n";
  }

  // Cerramos la clase
  $classContent .= "\n}";

  // Guardamos el contenido de la clase en un archivo con el nombre de la tabla
  $fileName = $tableName . ".php";
  $filePath = './clases/' . $fileName; // Cambia la ruta según tu preferencia

  file_put_contents($filePath, $classContent);
}

// Define el código SQL con la definición de las tablas
$sql = "
CREATE TABLE `db_cejasmy`.`products` (
  `id_product` int NOT NULL AUTO_INCREMENT,
  `price` float NOT NULL,
  `name` VARCHAR(200) NOT NULL,
  `description` TEXT,
  PRIMARY KEY (`id_product`)
) ENGINE = InnoDB;

// Aquí continua el resto del código SQL con las demás tablas...

CREATE TABLE `db_cejasmy`.`cart_details` (
  `id_cart` INT NOT NULL,
  `id_cart_details` INT NOT NULL AUTO_INCREMENT,
  `id_product` INT NOT NULL,
  `id_appointment` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_cart_details`)
) ENGINE = InnoDB;
";

// Generar las clases PHP a partir del código SQL
generateClassesFromSQL($sql);

?>
