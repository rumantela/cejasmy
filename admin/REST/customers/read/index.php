<?php


session_start();

include "../../../api/Customer.php";
include_once "../../../config/dbconfig.php";

$customer = new Customer();
$customer->setDB($db_connection);
$customer->setId(intval($_COOKIE['customer_id']));

$data = $customer->getCustomerData();

header("Content-Type: application/json");
echo json_encode(["success"=>"true","customer"=>$data]);
    
exit();





?>