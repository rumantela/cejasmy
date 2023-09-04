<?php




include __DIR__.'/AuthManager.php';
include __DIR__.'/DB.php';
require('PHPMailer/class.phpmailer.php');

class Login
{

    public $user;
    private $password;
    private $db;
    private $customer=null;
    private $connection;

    function __construct($params){
        $this->user = $params['user'];
        if(isset($params['password'])){
            $this->password = $params['password'];
        }
        $this->connection = $params['connection'];
        $this->db = new DB($params['connection']);
        $this->connect();
    }

    function connect(){
        $this->db->dbConnect();
    }

    function getUser(){
        return $this->user;
    }
    function setUser($user){
        $this->user = $user;
        return $this->user;
    }
    function resetPassword($email){
        $reset_key = $this->generateSalt();
        $sql="UPDATE users SET reset_key='".$reset_key."' WHERE nombreUsuario='".$email."'";
        $result = $this->db->query($sql);
        //var_dump($result);
        if($result){

            
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            return true;
        }
        return false;
    }
    private function generateSalt() {
        return base64_encode(random_bytes(32));
      }
    function canResetPassword($email,$key){
        $sql ="SELECT reset_key FROM users WHERE email=".$email;
        $result = $this->db->query($sql);
        if($result->rowCount()){
            $resetKey = $result->fetch();
            if($resetKey['reset_key']==$key){
                return true;
            }
        }
        return false;
    }
    function canLog(){
        $auth = new AuthManager($this->connection);
        if($auth->authenticateUser($this->user,$this->password)){

            $sql = "SELECT id_customer, firstname, email, phone FROM customers WHERE email='".$this->user."'";
            
            $rows = $this->db->query($sql);
            if($rows->rowCount()){
                $row = $rows->fetch();
                $this->customer = $row['id_customer'];
                return true;
            }
        }
        return false;

        
    }
    function getCustomer(){
        return $this->customer;
    }
    function dbDestroy(){
        $this->db->dbDestroy();
    }

}
