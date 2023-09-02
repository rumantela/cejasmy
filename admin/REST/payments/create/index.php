<?php

session_start();

include_once 'redsysHMAC256_API_PHP_4.0.2/apiRedsys.php';

$amount = $_POST['amount'];
$id = $_POST['order'];
$fuc = $_POST['fuc'];
$moneda = $_POST['currency'];
$trans = $_POST['transationType'];
$terminal = $_POST['terminal'];



$redsys = new RedsysAPI;

$redsys->setParameter("DS_MERCHANT_AMOUNT", $amount);
$redsys->setParameter("DS_MERCHANT_ORDER", $id);
$redsys->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
$redsys->setParameter("DS_MERCHANT_CURRENCY", $moneda);
$redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
$redsys->setParameter("DS_MERCHANT_TERMINAL", $terminal);
$redsys->setParameter("DS_MERCHANT_MERCHANTURL", $url);
$redsys->setParameter("DS_MERCHANT_URLOK", $urlOK);
$redsys->setParameter("DS_MERCHANT_URLKO", $urlKO);

$params = $miObj->createMerchantParameters($token);