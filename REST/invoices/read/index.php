<?php
include '../../../config/dbconfig.php';
require_once '../../../api/Invoice.php';




    
    $employee = new Employee($db_connection['db_server'],$db_connection['db_name'],$db_connection['db_user'],$db_connection['db_password']);
    
    // RESPONSE
    

    header("Content-Type: application/json");
    if($employees=$employee->readAll()){
        //var_dump($products);
        $aux = [];
        foreach($employees as $row){
            $row['actions']="";
            $aux[]=$row;
        }
        echo json_encode(['success'=>"true",'comments'=>$aux]);
    }else{
        echo json_encode(['success'=>"false"]);
    }

    die();