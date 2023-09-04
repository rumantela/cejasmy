<?php
class Dashboard {
    private $conn;

    public function __construct($host, $dbname, $username, $password) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $this->conn = new PDO($dsn, $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

   

   
    // Leer todos los empleados
    public function readAll() {
        $data = [
            "monthEarnings" => $this->getMonthEarnings(),
            "yearEarnings" => $this->getYearEarnings(),
            "appointments" => $this->getAppointments(),
            "allEarnings" => $this->getAllYearEarnings(),
        ];

        return $data;

    }

    public function getAppointments(){
        $query = "SELECT id_appointment FROM appointments WHERE status=1 OR status=2";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $i = $stmt->rowCount();
        $query = "SELECT id_appointment FROM appointments WHERE status=2";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $j = $stmt->rowCount();
        return ["all"=>$i,"paid"=>$j];
    }

    public function getAllYearEarnings($year=null){
        if($year==null){
            $year=date('Y');
        }
        $earnings = [
            $this->getMonthEarnings(mktime(0,0,0,0,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,1,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,2,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,3,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,4,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,5,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,6,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,7,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,8,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,9,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,10,date('d'),$year)),
            $this->getMonthEarnings(mktime(0,0,0,11,date('d'),$year)),
        
        ];
        //var_dump($earnings);
        return $earnings;
        
    }

    public function getYearEarnings($year=null){
        $query = "SELECT SUM(amount) AS amount FROM orders WHERE created < :monthUp AND created > :monthDown";
        
        $stmt = $this->conn->prepare($query);

        if($year==null){
            $ahora = date('Y-m-d');
            $monthUp = date('Y-m-d',strtotime($ahora. ' + 1 year'));
            $monthDown = date('Y-m-d',strtotime($ahora. ' - 1 year'));
            
        }else{
            $ahora = date('Y-m-d',$year);
            $monthUp = date('Y-m-d',strtotime($ahora. ' + 1 year'));
            $monthDown = date('Y-m-d',strtotime($ahora. ' - 1 year'));
        }

        // Bind los parámetros
        $stmt->bindParam(":monthUp", $monthUp);
        $stmt->bindParam(":monthDown", $monthDown);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMonthEarnings($month=null){
        

        $query = "SELECT SUM(amount) AS amount FROM orders WHERE created < :monthUp AND created > :monthDown";
        
        $stmt = $this->conn->prepare($query);

        if($month==null){
            $ahora = date('Y-m-d');
            $monthUp = date('Y-m-d',strtotime($ahora. ' + 1 month'));
            $monthDown = date('Y-m-d',strtotime($ahora. ' - 1 month'));
            
        }else{
            $ahora = date('Y-m-d',$month);
            $monthUp = date('Y-m-d',strtotime($ahora. ' + 1 month'));
            $monthDown = date('Y-m-d',strtotime($ahora. ' - 1 month'));
        }

        // Bind los parámetros
        $stmt->bindParam(":monthUp", $monthUp);
        $stmt->bindParam(":monthDown", $monthDown);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
