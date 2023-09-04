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

            $mail = new PHPMailer();

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.hostalia.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'cejasmy@hostalia.com';                     //SMTP username
                $mail->Password   = '682130633557bB$';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('webmaster@cejasmy.com', 'CejasMy');
                $mail->addReplyTo('webmaster@cejasmy.com', 'Information');
            
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Recuperación de contraseña';
                $mail->Body    = 'Pincha en el siguiente enlace';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                echo 'Message has been sent';
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