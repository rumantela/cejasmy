<?php


session_start();

include "../../../api/Customer.php";
include_once "../../../config/dbconfig.php";

$customer = new Customer();
$customer->setDB($db_connection);
if(isset($_COOKIE['customer_id'])){
    $customer->setId(intval($_COOKIE['customer_id']));
}

header("Content-Type: application/json");
if(isset($_GET['getAll'])){
    $data = $customer->getAllCustomers();
    $aux = [];
        foreach($data as $row){
            $row['actions']="";
            $customers[]=$row;
        }
    echo json_encode(['success'=>"true","customers"=>$customers]);    
}else{
    $data = $customer->getCustomerData();
    echo json_encode(["success"=>"true","customer"=>$data]);
    
}
    
exit();





?>