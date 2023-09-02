<?php
session_start();

include "../../api/Cart.php";
include_once "../../config/dbconfig.php";


$params = [
    'connection' => $db
];

$cart = new Cart();
$cart->setCustomer(1);
print $cart->getCustomer();