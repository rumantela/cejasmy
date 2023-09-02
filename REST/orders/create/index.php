<?php
session_start();

/** REST SERVICE for login */


include '../../../config/dbconfig.php';
require_once '../../../api/Order.php';
require_once '../../../api/Cart.php';
require_once '../../../api/CartDetails.php';


$host = $db_connection['db_server'];
$dbname = $db_connection['db_name'];
$user = $db_connection['db_user'];
$password = $db_connection['db_password'];

$order = new Order($host,$dbname,$user,$password);
$cart = new Cart(['connection' => $db_connection]);
$cartData = $cart->readCart($_POST['id_cart']);
$order->setIdCustomer($cartData['id_customer']);
$order->setIdCart($cartData['id_cart']);
$order->setAmount($cartData['amount']);
$order->setRef($_POST['ref']);
$cart_detail = $cart->getCartDetails();
foreach($cart_detail as $key => $value){
    $order_detail = new OrderDetails($host,$dbname,$user,$password);
    $order_detail->setIdOrder($order->getIdOrder());
    $order_detail->setIdProduct($value['id_product']);
    $order_detail->createOrderDetails();
}



header("Content-Type: application/json");

if($order->getIdOrder()){
    echo json_encode(["success"=>"true","id_order"=>$order->getRef()]);
}else{
    echo json_encode(["success"=>"false"]);        
}
exit();
