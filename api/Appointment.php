<?php

require __DIR__.'/DB.php';
include __DIR__.'/AuthManager.php';

class Appointment {
    private $idAppointment;
    private $idCustomer;
    private $idEmployee;
    private $dateAdd;
    private $dateUpd;
    private $status;
    private $db;
    

    public function __construct($conn,$params=null) {
        if($params!=null){
            $this->idAppointment = $params['idAppointment'];
            $this->idCustomer = $params['idCustomer'];
            $this->idEmployee = $params['idEmployee'];
            $this->dateAdd = $params['dateAdd'];
            $this->dateUpd = $params['dateUpd'];
            $this->status = $params['status'];
            $this->db= $params["connection"];
        }else{
            $this->db = $conn;
        }
        
    }

    public function getIdAppointment() {
        return $this->idAppointment;
    }

    public function setIdAppointment($idAppointment) {
        $this->idAppointment = $idAppointment;
    }

    public function getIdCustomer() {
        return $this->idCustomer;
    }

    public function setIdCustomer($idCustomer) {
        $this->idCustomer = $idCustomer;
    }

    public function getIdEmployee() {
        return $this->idEmployee;
    }

    public function setIdEmployee($idEmployee) {
        $this->idEmployee = $idEmployee;
    }

    public function getDateAdd() {
        return $this->dateAdd;
    }

    public function setDateAdd($dateAdd) {
        $this->dateAdd = $dateAdd;
    }

    public function getDateUpd() {
        return $this->dateUpd;
    }

    public function setDateUpd($dateUpd) {
        $this->dateUpd = $dateUpd;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }


    public function save() {
        $conn = new mysqli($this->db['db_server'],$this->db['db_user'],$this->db['db_password'],$this->db['db_name']);

        if ($this->idAppointment) {
            $query = "UPDATE appointments SET id_customer=?, id_employee=?, date_add=?, date_upd=?, status=? WHERE id_appointment=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iissii", $this->idCustomer, $this->idEmployee, $this->dateAdd, $this->dateUpd, $this->status, $this->idAppointment);
        } else {
            $query = "INSERT INTO appointments (id_customer, id_employee, date_add, date_upd, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iissi", $this->idCustomer, $this->idEmployee, $this->dateAdd, $this->dateUpd, $this->status);
        }

        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    public function getById($id) {
        $conn = new mysqli($this->db['db_server'],$this->db['db_user'],$this->db['db_password'],$this->db['db_name']);

        $query = "SELECT * FROM appointments WHERE id_appointment=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $conn->close();

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function getAll() {
        $conn = new mysqli($this->db['db_server'],$this->db['db_user'],$this->db['db_password'],$this->db['db_name']);
        $query = "SELECT a.date_upd, c.firstname, a.turn FROM appointments a LEFT JOIN customers c ON a.id_customer=c.id_customer";
        $result = $conn->query($query);
        $appointments = [];
        
        if(isset($result)){

            while ($row = $result->fetch_assoc()) {
                $appointments[] = $row;
            }
            $conn->close();
            return $appointments;
        }
        return $appointments;

    }

    public function getAllMyAppointments() {
        $conn = new mysqli($this->db['db_server'],$this->db['db_user'],$this->db['db_password'],$this->db['db_name']);
        var_dump($conn);
        $query = "SELECT a.date_upd, c.firstname, a.turn FROM appointments a LEFT JOIN customers c ON a.id_customer=c.id_customer";
        $result = $conn->query($query);
        $appointments = [];
        if(isset($result)){

            while ($row = $result->fetch_assoc()) {
                $appointments[] = $row;
            }
            $conn->close();
            return $appointments;
        }
        return $appointments;

    }

    public function update() {
        $conn = new mysqli($this->db['db_server'],$this->db['db_user'],$this->db['db_password'],$this->db['db_name']);

        $query = "UPDATE appointments SET id_customer=?, id_employee=?, date_add=?, date_upd=?, status=? WHERE id_appointment=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iissii", $this->idCustomer, $this->idEmployee, $this->dateAdd, $this->dateUpd, $this->status, $this->idAppointment);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    public function delete() {
        $conn = new mysqli($this->db['db_server'],$this->db['db_user'],$this->db['db_password'],$this->db['db_name']);

        $query = "DELETE FROM appointments WHERE id_appointment=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $this->idAppointment);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }


}

?>
