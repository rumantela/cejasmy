<?php

include __DIR__.'/AuthManager.php';
include __DIR__.'/DB.php';

class LoginAdmin
{

    public $user;
    private $password;
    private $db;
    private $customer=null;

    function __construct($params){
        $this->user = $params['user'];
        $this->password = $params['password'];
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
    
    function canLog(){
        $auth = new AuthManager();
        if($auth->authenticateEmployee($this->user,$this->password)){

            $sql = "SELECT id_employee as id_customer, firstname, email FROM employees WHERE email='".$this->user."'";
            
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