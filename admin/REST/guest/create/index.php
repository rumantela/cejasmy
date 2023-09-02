<?php

session_start();

include "../../../api/Customer.php";
include_once "../../../config/dbconfig.php";

$customer = new Customer();

$customer->setFirstname($_POST['firstname']);
$customer->setPhone($_POST['phone']);
$customer->setEmail($_POST['email']);
$customer->setDB($db_connection);
$exists = $customer->getCustomerByEmail($_POST['email']);

header("Content-Type: application/json");

if(!$exists){

    if($customer->createInvitate()){
        echo json_encode(["success"=>"true","id_customer"=>$customer->getId()]);
    }else{
        echo json_encode(["success"=>"false","error"=>"Couldn't create customer invitated!"]);        
    }

}else{
    echo json_encode(["success"=>"true","id_customer"=>$exists[0]]);
}
exit();


?>