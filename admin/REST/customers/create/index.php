<?php

session_start();

include "../../../api/Customer.php";
include_once "../../../config/dbconfig.php";

$customer = new Customer();

if(isset($_POST['phone'])){
    $customer->setPhone($_POST['phone']);
}
if(isset($_POST['dni'])){
    $customer->setDNI($_POST['dni']);
}
if(isset($_POST['dir'])){
    $customer->setDir($_POST['dir']);
}
$customer->setFirstname($_POST['firstname']);
$customer->setLastname($_POST['lastname']);
$customer->setEmail($_POST['email']);
$customer->setPassword($_POST['password']);
$customer->setDB($db_connection);
$exists = $customer->getCustomerByEmail($_POST['email']);

header("Content-Type: application/json");

if(!$exists){
    
    if($customer->createSimpleCustomer()){
        echo json_encode(["success"=>"true","id_customer"=>$customer->getId()]);
    }else{
        echo json_encode(["success"=>"false","error"=>"Couldn't create customer invitated!"]);        
    }

}else{
    echo json_encode(["success"=>"true","id_customer"=>$exists[0]]);
}
exit();


?>