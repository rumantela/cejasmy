<?php
session_start();

/** REST SERVICE for login */


include '../../config/dbconfig.php';
require_once '../../api/Login.php';

if(!isset($_SESSION['user'])){

    $params = [
        'user' => $_POST['email'],
        'password' => $_POST['password'],
        'connection' => $db_connection
    ];
    
    
    $login = new Login($params);
    
    // RESPONSE
    

    header("Content-Type: application/json");
    if($login->canLog()){
        $_SESSION['user_name']=$login->getCustomer();
        echo json_encode(["login"=>"true","id_customer"=>$login->getCustomer()]);
    }else{
        session_destroy();
        echo json_encode(["login"=>"false"]);
    }
    
    $login->dbDestroy();                // Cerrar conexion con la DB
}else{
    header("Content-Type: application/json");
    echo json_encode(["login"=>"true","id_customer"=>$_SESSION['user_name']]);
}

exit();
