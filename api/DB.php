<?php




class DB
{
    public $name, $server, $user, $password;
    private $db;
        
    function __construct($db_connection){
        //var_dump($db_connection);
        $this->server = $db_connection['db_server'];
        $this->user = $db_connection['db_user'];
        $this->password = $db_connection['db_password'];
        $this->name = $db_connection['db_name'];
        $this->dbConnect();
    }

    public function query($sql){
        
        return $resp = $this->db->query($sql);
       
    }
    public function query2($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function lastInsertId(){
        return $this->db->lastInsertId();
    }

    public function dbConnect(){
        try{
            $dsn = 'mysql:host='.$this->server.';dbname='.$this->name;
            $nombre_usuario = $this->user;
            $contraseña = $this->password;
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            ); 
    
            $gbd = new PDO($dsn, $nombre_usuario, $contraseña, $opciones);
            $this->db = $gbd;
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
        return true;
    }

    public function getTable($table_name,$where=null){
        $sql = "SELECT * FROM ".$table_name;
        if($where!=null){
            $sql .=" WHERE ".$where;
        }
        $result = $this->db->query($sql);
        if($result){
            while($row = $result->fetch()){
                $table[] = $row;
            }

        }
        return $table;
    }

    public function dbDestroy(){
        $this->db = null;
        return true;
    }

    public function getEmployees(){
        return $this->getTable('employees');
    }

    public function getCustomers(){
        return $this->getTable('customers');
    }

    public function getProducts(){
        return $this->getTable('products');
    }
    public function getOrders(){
        return $this->getTable('orders');
    }
    public function getCart(){
        return $this->getTable('carts');
    }
}