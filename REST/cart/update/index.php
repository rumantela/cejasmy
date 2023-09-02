<?php
session_start();

include "../../../api/Cart.php";
include_once "../../../config/dbconfig.php";


$params = [
    'connection' => $db,
    'customer' => 1,
    'amount' => 30.00,
    'products' => [
        'id_product' => 1,
        'id_appointment' => 1,
        'price' => 30.00
    ]
];
$idCart = 1;
/*
$params = [
    'id' => $_POST['id_cart'],
    'connection' => $db,
    'customer' => $_POST['id_customer'],
    'amount' => 0,
    'updated' => 'currentTime()',
    'products' => $_POST['products']
];
*/

// Check data needed if something missing 
// exit() send error
$cart = new Cart();
if(isset($_POST['id_cart'])||isset($_POST['amount'])||isset($_POST['products'])){
    $cart->setId($_POST['id_cart']);
    $cart->setAmount($_POST['amount']);
    $cart->setProducts($_POST['products']);
}else{
    header("Content-Type: application/json");
    echo json_encode(["error"=>"No id or amount received! Nothing done."]);
    exit();
}


// No errors, update cart
$cart1 = new Cart($params);
$cart1->setId($idCart);


header("Content-Type: application/json");

if($cart->updateCart()){
    echo json_encode(["success"=>"true","id_cart"=>$cart->getId()]);
}else{
    echo json_encode(["success"=>"false"]);        
}
exit();