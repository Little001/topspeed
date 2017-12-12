<?php

class DataBaseQuery {
    private $conn;
    public $code = "";

    public function DataBaseQuery() {
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
   
        if ($this->conn->query($sql) === TRUE) {
            return($this->generateCode($this->conn->insert_id));
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
   
        if ($this->conn->query($sql) === TRUE) {
            return($this->generateCode($this->conn->insert_id));
        } else {
            echo "New enjoy ride Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    public function getCode() {
        return $this->code;
    }

    private function generateCode($id) {
        $this->code = hash('crc32', 'id='.$id);
        $sql = "INSERT INTO codes";
        $sql .= " (code)";
        $sql .= "VALUES ";
        $sql .= "('" . $this->code ."')";
   
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