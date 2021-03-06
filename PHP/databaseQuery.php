<?php
require_once('PHP/models/orderResponse.php');
require_once('PHP/models/position.php');
require_once('PHP/models/checkCode.php');
require_once('PHP/enums.php');
require_once('PHP/controllers/enumsController.php');

class DataBaseQuery {
    private $conn;
    public $code = "";
    public $lastId = "";
    public $response;

    public function DataBaseQuery() {
        $this->response = new OrderResponse;
        $this->createConnection();
    }

    public function checkReservationLocation($code, $location) {
        $ride = $this->getRideByCode($code);
        if ($ride == false) {
            echo "delivery is not equal";
            return false;
        }
        $checkCodeObj = $this->getCodeInformation($ride["id_order"], $ride["method"]);
        if ($checkCodeObj->delivery != $location) {
            echo "delivery is not equal";
            return false;
        }
        return true;
    }

    public function insertReservation($ReservationObject) {
        $sql = "INSERT INTO reservation";
        $sql .= " (code, date, time) ";
        $sql .= "VALUES ";
        $sql .= "('" . $ReservationObject->code ."', ";
        $sql .= "'" . $ReservationObject->date ."', ";
        $sql .= "'" . $ReservationObject->time ."')";
   
        if ($this->conn->query($sql) === TRUE) {
            if($this->invalidateCode($ReservationObject->code)) {
                return true;
            }
            echo "invalidate Code Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        } else {
            echo "New reservation Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    private function invalidateCode($code) {
        $sql = "UPDATE codes ";
        $sql .= "SET valid = 0 ";
        $sql .= "WHERE code='" . $code . "'";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Invalidate Code Error: " . $sql . "<br>" . $this->conn->error;
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

    public function getCodeInformation($id_order, $method) {
        $table = ($method == "enjoy") ? "enjoy_ride" : "hire_ride";
        $sql = "SELECT * FROM " . $table . " WHERE id=" .$id_order;
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $checkCodeObj = new CheckCode();
            $checkCodeObj->customerName = $row["customerName"];
            $checkCodeObj->delivery = $row["delivery"];
            $checkCodeObj->duration = $row["duration"];
            $checkCodeObj->rideMethod = EnumsController::getRideMethodText(intval($row["delivery"]));

            return $checkCodeObj;
        } else {
            echo "0 results";
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

    public function getPositions($month_year) {
        $sql = "SELECT position, place FROM location WHERE month_year='" .$month_year ."'";
        $result = mysqli_query($this->conn, $sql);
        $positions = array();

        while($row = mysqli_fetch_assoc($result)) {
            $positions[] = $row;
        } 
        if (empty($positions)) {
            for ($i = 0; $i < 6; $i++) {
                $default = new Position;
                $default->position = $i + 1;
                $default->place = Location::NOT_SPECIFY;
                $positions[] = $default;
            }
        }

        return $positions;
    }

    public function setPositions($locationModel) {
        if (!$this->deletePosition($locationModel->month)) {
            return false;
        }

        foreach ($locationModel->rows as &$row) {
            $sql = "INSERT INTO location";
            $sql .= " (month_year, place, position) ";
            $sql .= "VALUES ";
            $sql .= "('" . $locationModel->month ."', ";
            $sql .= "" . $row["place"] .", ";
            $sql .= "" . $row["position"] .")";
    
            if ($this->conn->query($sql) === TRUE) {
            } else {
                echo "INSERT location Error: " . $sql . "<br>" . $this->conn->error;
                return false;
            }
        }

        return true;
    }

    private function deletePosition($month_year) {
        $sql = "DELETE FROM location WHERE month_year='" . $month_year . "'";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Delete position error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    public function getCode() {
        return $this->code;
    }

    public function getRideByCode($code) {
        $sql = "SELECT * FROM codes WHERE code='" .$code."' AND valid=1";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
            //echo "0 results";
        }
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