<?php
session_start();

include "../../../api/Cart.php";
include_once "../../../config/dbconfig.php";

/*
$params = [
    'connection' => $db,
    'customer' => 1,
    'amount' => 30.00,
    'created' => date('YYYY-MM-DD - hh:mm'),
    'updated' => date('YYYY-MM-DD - hh:mm'),
    'products' => [
        'id_product' => 1,
        'id_appointment' => 1,
        'price' => 30.00
    ]
];
*/

$params = [
    'connection' => $db_connection,
    'customer' => $_POST['customer_id'],
    'amount' => 0,
    'created' => 'currentTime()',
    'updated' => 'currentTime()',
    'products' => [
    ]
];

$cart = new Cart($params);



header("Content-Type: application/json");

if($cart->createCart()){
    echo json_encode(["success"=>"true","id_cart"=>$cart->getId()]);
}else{
    echo json_encode(["success"=>"false"]);        
}
exit();
