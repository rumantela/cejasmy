<?php

require __DIR__.'/DB.php';
include __DIR__.'/AuthManager.php';
class Customer{


    private $id, $firstname, $lastname, $email, $phone, $password, $birthday, $newsletter, $newsletter_date,$newsletter_ip,$DNI,$dir;
    private $db,$passwordHash,$connection;

    public function __construct($params=null)
    {
        if(isset($params)){
            $this->db = new DB($params['connection']);
            $this->connection = $params['connection'];
            $this->firstname = $params['firstname'];
            $this->lastname = $params['lastname'];
            $this->phone = $params['phone'];
            $this->password = $params['password'];
            $this->birthday = $params['birthday'];
            $this->newsletter = $params['newsletter'];
            $this->newsletter_date = $params['newsletter_date'];
            $this->newsletter_ip = $params['newsletter_ip'];
        }else{
            return false;
        }
    }

    public function dbDestroy(){
        $this->db->dbDestroy();
    }

    public function setDB($db){
        $this->db=new DB($db);
    }

    public function createInvitate(){
        $sql = "
            INSERT INTO customers (firstname,phone, email,password)
            VALUES ('".$this->firstname."','".$this->phone."','".$this->email."','cejasmy')
        ";
        
        $this->db->query($sql);
        return $this->id = $this->db->lastInsertId();

    }
    public function createCustomer(){
        $sql = "INSERT INTO `customers` (`firstname`, `lastname`, `email`,`phone`, `password`) 
        VALUES ('".$this->firstname
        ."','".$this->lastname
        ."','".$this->email
        ."','".$this->phone
        ."','".$this->password."')";
        $this->db->query($sql);
        //var_dump($sql);
        
        $this->id = $this->db->lastInsertId();
        if($this->id){
            return true;
        }
        return false;
    }

    public function createSimpleCustomer(){
        $sql = "INSERT INTO `customers` (`firstname`, `lastname`, `email`, `password`,`phone`,`dni`) 
        VALUES ('".$this->firstname
        ."','".$this->lastname
        ."','".$this->email
        ."', '".$this->passwordHash
        ."', '".$this->phone
        ."', '".$this->DNI
        ."')";
        $rows = $this->db->query($sql);
        //var_dump($sql);
        $this->id = $this->db->lastInsertId();
        if($this->id){
            $this->registerUser();
            return true;
        }
        return false;
    }

    public function getCustomerData(){
        
        $sql = "
            SELECT * FROM customers WHERE id_customer='".$this->id."'
        ";
        return $this->db->query($sql)->fetch();
    }

    public function getCustomerById($id){
        $sql = "
            SELECT * FROM customers WHERE id_customer='".$id."'
        ";
        return $this->db->query($sql)->fetch();
    }

    public function getCustomerByEmail($email){
        $sql = "
            SELECT id_customer FROM customers WHERE email='".$email."'
        ";
        return $this->db->query($sql)->fetch();
    }

    public function registerUser(){
        if(isset($this->email)&&isset($this->password)){
            $auth = new AuthManager($this->connection);
            
            return $auth->registerUser($this->email,$this->password);
        }else{
            
            return false;
        }
    }
    public function getAllCustomers(){
        $sql = "
            SELECT * FROM customers;
        ";
        return $this->db->query($sql)->fetchAll();
    }


    // Getter setters

    public function setId($data){
        $this->id = $data;
    }
    public function setFirstname($data){
        $this->firstname = $data;
    }
    public function setLastname($data){
        $this->lastname = $data;
    }
    public function setEmail($data){
        $this->email = $data;
    }
    public function setPhone($data){
        $this->phone = $data;
    }
    public function setPassword($data){
        $auth = new AuthManager($this->connection);
        $this->passwordHash = $auth->getHashPassword($data);
        $this->password = $data;
    }
    public function setBirthday($data){
        $this->birthday = $data;
    }
    public function setNewsletter($data){
        $this->newsletter = $data;
    }
    public function setNewsletterDate($data){
        $this->newsletter_date = $data;
    }
    public function setNewsletterIp($data){
        $this->newsletter_ip = $data;
    }

    public function setDNI($data){
        $this->DNI = $data;
    }
    public function getDNI(){
        return $this->DNI;
    }

    public function setDir($data){
        $this->dir = $data;
    }
    public function getDir(){
        return $this->dir;
    }

    public function getId(){
        return $this->id;
    }
    public function getFirstname(){
        return $this->firstname;
    }
    public function getLastname(){
        return $this->lastname;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPhone(){
        return $this->phone;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getBirthday(){
        return $this->birthday;
    }
    public function getNewsletter(){
        return $this->newsletter;
    }
    public function getNewsletterDate(){
        return $this->newsletter_date;
    }
    public function getNewsletterIp(){
        return $this->newsletter_ip;
    }
}