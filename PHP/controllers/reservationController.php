<?php
require_once('PHP/models/reservation.php');
require_once('PHP/databaseQuery.php');

class ReservationController {
    public $errors = "";
    private $code = "";
    private $date = "";
    private $time = "";
    private $email = "";
    private $ReservationObject;
    private $databaseQuery;

    public function ReservationController($POST) {
        $this->ReservationObject = new Reservation();
        $this->databaseQuery = new DataBaseQuery();
        
        if ($this->checkData($POST)) { 

            if ($this->databaseQuery->checkReservationLocation($this->ReservationObject->code, $this->ReservationObject->location)) {
                if ($this->databaseQuery->insertReservation($this->ReservationObject)) {
                    if (!$this->sendEmail()) {
                        $this->errors .= "send email ERROR";
                    }
                } else {
                    $this->errors .= "insert reservation";
                }
            } else {
                $this->errors .= "reservation check reservation location";
            }
        } else {
            $this->errors .= "reservation data";
        }
    }

    private function sendEmail() {
        $to = $this->email;
        $subject = "Rezervace TopSpeed";
        $message = "Vaše rezervace je na" . $this->date . "-" . $this->time;
        $headers = "from: info@topspeedbrno.cz \n";
        $headers .= "X-mailer: phpWebmail \n";
        
        if (mail($to, $subject, $message, $headers)) {
        } else {
            echo "CHYBA MAIL - odeslání se nepovedlo";
            return false;
        }

        $to = "info@topspeedbrno.cz";
        $subject = "Rezervace TopSpeed";
        $message = "Byla přidána rezervace na->" . $this->date . "-" . $this->time;
        $headers = "from: info@topspeedbrno.cz \n";
        $headers .= "X-mailer: phpWebmail \n";
        
        if (mail($to, $subject, $message, $headers)) {
        } else {
            echo "CHYBA MAIL - odeslání se nepovedlo";
            return false;
        }

        return true;
    }

    private function checkData ($POST) {
        if ((!isset ($POST["code"])) || (strlen($POST["code"]) < 1)) {
            $this->errors .= "code ";
            return false;    
        }
        if (!$this->databaseQuery->getRideByCode($POST["code"])) {
            $this->errors .= "code not exists ";
            return false;
        }
        $this->ReservationObject->code = $POST["code"];

        //date
        if ((!isset ($POST["date"])) || (strlen($POST["date"]) < 1)) {
            $this->errors .= "date ";
            return false;    
        }
        $this->ReservationObject->date = $POST["date"];

        if ((!isset ($POST["time"])) || (strlen($POST["time"]) < 1)) {
            $this->errors .= "time ";
            return false;    
        }
        $this->ReservationObject->time = $POST["time"];

        if (!isset ($POST["location"])) {
            $this->errors .= "location ";
            return false;    
        }
        $this->ReservationObject->location = $POST["location"];

        return true;
    }
}
?>