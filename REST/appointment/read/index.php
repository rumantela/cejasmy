<?php
session_start();

include "../../../api/Appointment.php";
include_once "../../../config/dbconfig.php";


$params = [
];


$appointments = new Appointment($db_connection,null);

header("Content-Type: application/json");
if($_POST['getAllData']=="true"){
    $data = $appointments->getAllAppointments();
    $aux = [];
    foreach($data as $row){
        $row['actions']="";
        $aux[]=$row;
    }
    echo json_encode(['success'=>"true","appointments"=>$aux]);
}else{
    echo json_encode(["success"=>"true","appointments"=>$appointments->getAll()]);
    
}


     

exit();
