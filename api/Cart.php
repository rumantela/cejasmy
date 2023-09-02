<?php

require __DIR__.'/DB.php';

class Cart{

    public $id,$products,$created,$updated,$amount,$customer;
    private $db;
    function __construct($params=null)
    {
        if($params!=null){
            $this->db = new DB($params['connection']);
            if(isset($params['id'])){
                $this->id = $params['id'];
                $this->getCart($this->id);
            }else{
                $this->products = $params['products'];
                $this->created = $params['created'];
                $this->updated = $params['updated'];
                $this->amount = $params['amount'];
                $this->customer = $params['customer'];
            }
                
        }else{

        }
    }

    public function readCart($id){
        $sql ="
            SELECT c.*, cd.* FROM carts c
            INNER JOIN cart_details cd ON c.id_cart=cd.id_cart WHERE c.id_cart=".$id."
        ";
        return $this->db->query($sql);

    }

    public function createCart(){
        $sql = "INSERT INTO `carts` (`id_cart`, `id_customer`, `amount`, `created`, `updated`) 
        VALUES (NULL, ".$this->customer.", ".$this->amount.", current_timestamp(), current_timestamp())";
        $rows = $this->db->query($sql);
        
        $this->id = $this->db->lastInsertId();
        if($rows->rowCount()){
            return true;
        }
        return false;
    }


    public function updateCart(){
        $sql = "UPDATE carts SET amount=".$this->amount." WHERE id_cart=".$this->id;
        return $this->db->query($sql);
    }
    public function addProduct($idProduct,$idCart,$price,$id_appointment){

        $sql = "INSERT INTO cart_details (id_product, id_cart,price,id_appointment) VALUES (".$idProduct.",".$idCart.",".$price.",".$id_appointment.")";
        $resp = $this->db->query($sql);
        
        return $this->db->lastInsertId();
    }
    public function getCartDetails(){
        $sql = "SELECT * FROM cart_details WHERE id_cart=".$this->id;
        $resp = $this->db->query($sql);
        return $resp->fetchAll();
    }

    public function addAppointment($idCustomer,$date){
        $result = explode(' ',$date);
        $subresult = explode(':',$result[1]);
        if((int)$subresult[0]<4){
            $turn = 1;
        }else{
            $turn = 2;
        }
        $sql = "
            INSERT INTO appointments (id_customer,date_add,date_upd,status,turn) VALUES (".$idCustomer.",
            '".$date."',
            '".$date."',
            1,
            ".$turn.")
        ";
        $this->db->query($sql);
        return $this->db->lastInsertId();
        
    }

    public function dbDestroy(){
        $this->db->dbDestroy();
    }

    /** Getter */
    public function getCart($id){
        $resp = $this->readCart($id);
        $data = [];

        while($row = $resp->fetch()){
            $data[] = $row;
        }
        return $data;
    }
    public function getProducts(){
        return $this->products;
    }
    public function getId(){
        return $this->id;
    }
    public function getAmount(){
        return $this->amount;
    }
    public function getCreated(){
        return $this->created;
    }
    public function getUpdated(){
        return $this->updated;
    }
    public function getCustomer(){
        return $this->customer;
    }

    /** SETTERS */

    public function setProducts($params){
        $this->products = $params;
    }
    public function setAmount($params){
        $this->amount = $params;
    }
    public function setCreated($params){
        $this->created = $params;
    }
    public function setUpdated($params){
        $this->updated = $params;
    }
    public function setCustomer($params){
        $this->customer = $params;
    }
    public function setId($params){
        $this->id = $params;
    }


    
}