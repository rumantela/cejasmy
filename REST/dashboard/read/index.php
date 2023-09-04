<?php
session_start();

include '../../../config/dbconfig.php';
require_once '../../../api/Dashboard.php';




    
    $dashboard = new Dashboard($db_connection['db_server'],$db_connection['db_name'],$db_connection['db_user'],$db_connection['db_password']);
    
    // RESPONSE
    $data=$dashboard->readAll();

    header("Content-Type: application/json");
    if($data){
        
        echo json_encode(['success'=>"true",'data'=>$data]);
    }else{
        
        echo json_encode(['success'=>"false",'data'=>$data]);
    }

    die();