<?php

include '../../../config/dbconfig.php';
require_once '../../../api/Product.php';




    
    $product = new Product($db_connection['db_server'],$db_connection['db_name'],$db_connection['db_user'],$db_connection['db_password']);
    
    // RESPONSE
    

    header("Content-Type: application/json");
    if($products=$product->getAllProducts()){
        //var_dump($products);
        $aux = [];
        foreach($products as $row){
            $row['actions']="";
            $aux[]=$row;
        }
        echo json_encode(['success'=>"true",'products'=>$aux]);
    }else{
        echo json_encode(['success'=>"false"]);
    }

    die();