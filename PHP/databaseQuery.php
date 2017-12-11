<?php

class DataBaseQuery {
    private $conn;

    public function DataBaseQuery() {
        $this->createConnection();
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
            echo "New record created successfully";
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
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
            echo "New record created successfully";
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
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