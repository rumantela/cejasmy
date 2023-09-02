<?php
session_start();

include "../../../api/Appointment.php";
include_once "../../../config/dbconfig.php";


$params = [
];


$appointments = new Appointment();



header("Content-Type: application/json");
echo json_encode(["success"=>"true","appointments"=>$appointments->getAll()]);

     

exit();
