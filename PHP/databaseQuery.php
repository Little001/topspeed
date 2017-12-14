<?php
require_once('PHP/models/orderResponse.php');

class DataBaseQuery {
    private $conn;
    public $code = "";
    public $lastId = "";
    public $response;

    public function DataBaseQuery() {
        $this->response = new OrderResponse;
        $this->createConnection();
    }

    public function insertReservation($ReservationObject) {
        $sql = "INSERT INTO reservation";
        $sql .= " (code, date, time, email) ";
        $sql .= "VALUES ";
        $sql .= "('" . $ReservationObject->code ."', ";
        $sql .= "'" . $ReservationObject->date ."', ";
        $sql .= "'" . $ReservationObject->time ."', ";
        $sql .= "'" . $ReservationObject->email ."')";
   
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "New reservation Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    public function getReservation($date) {
        $sql = "SELECT (date, time) FROM reservation WHERE date='" .$date."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
            // output data of each row
            /*while($row = $result->fetch_assoc()) {
                print_r($row);
            } */
        } else {
            //echo "0 results";
        }
    }

    public function insertHireRide($HireRide) {
        $sql = "INSERT INTO hire_ride";
        $sql .= " (street, city, psc, customerName, customerStreet, customerCity, customerPsc, customerEmail,";
        $sql .= " customerPhone, payMethod, duration, delivery, deliveryMethod) ";
        $sql .= "VALUES ";
        $sql .= "('" . $HireRide->street ."', ";
        $sql .= "'" . $HireRide->city ."', ";
        $sql .= "" . $HireRide->psc .", ";
        $sql .= "'" . $HireRide->customerName ."', ";
        $sql .= "'" . $HireRide->customerStreet ."', ";
        $sql .= "'" . $HireRide->customerCity ."', ";
        $sql .= "'" . $HireRide->customerPsc ."', ";
        $sql .= "'" . $HireRide->customerEmail ."', ";
        $sql .= "'" . $HireRide->customerPhone ."', ";
        $sql .= "" . $HireRide->payMethod .", ";
        $sql .= "" . $HireRide->duration .", ";
        $sql .= "" . $HireRide->delivery .", ";
        $sql .= "" . $HireRide->deliveryMethod .")";

        $this->response->rideMethod = "Pronájmutí vozu";
        $this->response->customerName = $HireRide->customerName;
        $this->response->delivery = $HireRide->delivery;
        $this->response->duration = $HireRide->duration;
   
        if ($this->conn->query($sql) === TRUE) {
            $this->lastID = $this->conn->insert_id;
            return($this->generateCode($this->lastID, "hire"));
        } else {
            echo "New hire ride Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    public function insertEnjoyRide($HireRide) {
        $sql = "INSERT INTO enjoy_ride";
        $sql .= " (customerName, customerStreet, customerCity, customerPsc, customerEmail,";
        $sql .= " customerPhone, payMethod, duration, delivery, deliveryMethod) ";
        $sql .= "VALUES ";
        $sql .= "('" . $HireRide->customerName ."', ";
        $sql .= "'" . $HireRide->customerStreet ."', ";
        $sql .= "'" . $HireRide->customerCity ."', ";
        $sql .= "'" . $HireRide->customerPsc ."', ";
        $sql .= "'" . $HireRide->customerEmail ."', ";
        $sql .= "'" . $HireRide->customerPhone ."', ";
        $sql .= "" . $HireRide->payMethod .", ";
        $sql .= "" . $HireRide->duration .", ";
        $sql .= "" . $HireRide->delivery .", ";
        $sql .= "" . $HireRide->deliveryMethod .")";

        $this->response->rideMethod = "Zážitková jízda";
        $this->response->customerName = $HireRide->customerName;
        $this->response->delivery = $HireRide->delivery;
        $this->response->duration = $HireRide->duration;
   
        if ($this->conn->query($sql) === TRUE) {
            $this->lastID = $this->conn->insert_id;
            return($this->generateCode($this->lastID, "enjoy"));
        } else {
            echo "New enjoy ride Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    public function getCode() {
        return $this->code;
    }

    private function generateCode($id, $method) {
        $this->code = hash('crc32', 'id='.$id);
        $this->response->code = $this->code;
        $sql = "INSERT INTO codes";
        $sql .= " (code, id_order, method)";
        $sql .= "VALUES ";
        $sql .= "('" . $this->code ."', ";
        $sql .= "" . $id .", ";
        $sql .= "'" . $method ."')";
   
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Generate Code Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    private function createConnection() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "topspeeddb";
        
        // Create connection
        $this->conn = new mysqli($servername, $username, $password, $db);
        
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } 
    }
}

?>