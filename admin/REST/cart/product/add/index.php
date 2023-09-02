<?php
session_start();

/** REST SERVICE for login */


include '../../../../config/dbconfig.php';
require_once '../../../../api/Cart.php';



    $params = [
        'id' => $_POST['customer_id'],
        'connection' => $db_connection
    ];
    
    $idCart = $_POST['cart_id'];
    $cart = new Cart($params);

    $response1 = $cart->addProduct($_POST['product_id'],$_POST['cart_id'],$_POST['price']);
    $response2 = $cart->addAppointment($_POST['customer_id'],$_POST['date']);
    //var_dump($response1);
    //var_dump($response2);
    // RESPONSE
    
    header("Content-Type: application/json");
    if($response1 && $response2){
        
        echo json_encode(["success"=>"true",'respuesta'=>$response2]);
    }else{
        echo json_encode(["success"=>"false",'respuesta'=>$response2]);    
        //echo json_encode(["errors"=>$response1.$response2]);
    }
    
    $cart->dbDestroy();                // Cerrar conexion con la DB


exit();