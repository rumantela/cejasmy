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

    $id_appointment = $cart->addAppointment($_POST['customer_id'],$_POST['date']);
    $response1 = $cart->addProduct($_POST['product_id'],$_POST['cart_id'],$_POST['price'], $id_appointment);
    
    // RESPONSE
    
    header("Content-Type: application/json");
    if($response1){
        
        echo json_encode(["success"=>"true",'respuesta'=>$response1]);
    }else{
        echo json_encode(["success"=>"false",'respuesta'=>$response1]);    
        //echo json_encode(["errors"=>$response1.$response2]);
    }
    
    $cart->dbDestroy();                // Cerrar conexion con la DB


exit();