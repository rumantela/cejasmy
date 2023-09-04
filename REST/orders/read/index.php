<?php

include '../../../config/dbconfig.php';
require_once '../../../api/Order.php';




    
    $order = new Order($db_connection['db_server'],$db_connection['db_name'],$db_connection['db_user'],$db_connection['db_password']);
    
    // RESPONSE
    

    header("Content-Type: application/json");
    if($orders=$order->getAllOrders()){
        //var_dump($products);
        $aux = [];
        foreach($orders as $row){
            $row['actions']="";
            $aux[]=$row;
        }
        echo json_encode(['success'=>"true",'orders'=>$aux]);
    }else{
        echo json_encode(['success'=>"false"]);
    }

    die();