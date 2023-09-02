<?php
session_start();

/** REST SERVICE for login */


include '../../../config/dbconfig.php';
require_once '../../../api/LoginAdmin.php';

if(!isset($_SESSION['user'])){

    $params = [
        'user' => $_POST['email'],
        'password' => $_POST['password'],
        'connection' => $db_connection
    ];
    
    
    $login = new LoginAdmin($params);
    
    // RESPONSE
    
    header("Content-Type: application/json");
    if($login->canLog()){
        $_SESSION['user_name']=$login->getCustomer();
        echo json_encode(["login"=>"true","id_employee"=>$login->getCustomer()]);
    }else{
        session_destroy();
        echo json_encode(["login"=>"false"]);
    }
    
    $login->dbDestroy();                // Cerrar conexion con la DB
}else{
    header("Content-Type: application/json");
    echo json_encode(["login"=>"true","id_employee"=>$_SESSION['user_name']]);
}

exit();
