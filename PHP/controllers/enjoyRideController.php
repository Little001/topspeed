<?php
require_once('PHP/models/enjoyRide.php');
require_once('PHP/databaseQuery.php');
require_once('PHP/enums.php');

class EnjoyRideController {
    public $errors = "";
    private $EnjoyRideObject;
    public $databaseQuery;

    public function EnjoyRideController($POST) {
        $this->EnjoyRideObject = new EnjoyRide();
        $this->databaseQuery = new DataBaseQuery();
        if ($this->checkData($POST)) {
            if ($this->databaseQuery->insertEnjoyRide($this->EnjoyRideObject)) {
                if(!$this->sendEmail()) {
                    $this->errors .= "send email ERROR";
                }
            } else {
                $this->errors .= "insert enjoy ride";
            }
        } else {
            echo "fail data" . $this->errors;
        }
    }

    private function checkData ($POST) {
        if ((!isset ($POST["customerName"])) || (strlen($POST["customerName"]) < 1)) {
            $this->errors .= "customerName ";
            return false;    
        }
        $this->EnjoyRideObject->customerName = $POST["customerName"];

        if ((!isset ($POST["customerStreet"])) || (strlen($POST["customerStreet"]) < 1)) {
            $this->errors .= "customerStreet ";
            return false;    
        }
        $this->EnjoyRideObject->customerStreet = $POST["customerStreet"];

        if ((!isset ($POST["customerCity"])) || (strlen($POST["customerCity"]) < 1)) {
            $this->errors .= "customerCity ";
            return false;    
        }
        $this->EnjoyRideObject->customerCity = $POST["customerCity"];

        if ((!isset ($POST["customerPsc"])) || (strlen($POST["customerPsc"]) < 1)) {
            $this->errors .= "customerPsc ";
            return false;    
        }
        $this->EnjoyRideObject->customerPsc = $POST["customerPsc"];

        //email
        if ((!isset ($POST["customerEmail"])) || (strlen($POST["customerEmail"]) < 1)) {
            $this->errors .= "customerEmail ";
            return false;    
        }
        if (!filter_var($POST["customerEmail"], FILTER_VALIDATE_EMAIL)) {
            $this->errors .= "customerEmail ";
            return false;
        }
        $this->EnjoyRideObject->customerEmail = $POST["customerEmail"];

        if ((!isset ($POST["customerPhone"])) || (strlen($POST["customerPhone"]) < 1)) {
            $this->errors .= "customerPhone ";
            return false;    
        }
        $this->EnjoyRideObject->customerPhone = $POST["customerPhone"];

        //payMethod
        if (!(isset ($POST["payMethod"]))) {
            $this->errors .= "payMethod ";
            return false;    
        }
        if (!$this->getPayMethod($POST["payMethod"])) {
            $this->errors .= "payMethod enums";
            return false;
        }

        //duration
        if (!(isset ($POST["duration"]))) {
            $this->errors .= "duration ";
            return false;    
        }
        if (!$this->getDuration($POST["duration"])) {
            $this->errors .= "duration enums";
            return false;
        }

        //delivery
        if (!(isset ($POST["delivery"]))) {
            $this->errors .= "delivery ";
            return false;    
        }
        if (!$this->getDelivery($POST["delivery"])) {
            $this->errors .= "delivery enums";
            return false;
        }

        //delivery method
        if (!(isset ($POST["deliveryMethod"]))) {
            $this->errors .= "deliveryMethod ";
            return false;    
        }
        if (!$this->getDeliveryMethod($POST["deliveryMethod"])) {
            $this->errors .= "deliveryMethod enums";
            return false;
        }

        return true;
    }

    private function getPayMethod($payMethod) {
        switch ($payMethod) {
            case PayMethod::BankAccount:
                $this->EnjoyRideObject->payMethod = PayMethod::BankAccount;
                return true;
            case PayMethod::CashOnDelivery:
                $this->EnjoyRideObject->payMethod = PayMethod::CashOnDelivery;
                return true;
            default: 
                return false;
        }
    }

    private function getDuration($duration) {
        switch ($duration) {
            case Duration::TWELVE_HOURS_PRICE:
                $this->EnjoyRideObject->duration = Duration::TWELVE_HOURS_PRICE;
                return true;
            case Duration::ONE_DAY_PRICE:
                $this->EnjoyRideObject->duration = Duration::ONE_DAY_PRICE;
                return true;
            case Duration::TWO_DAY_PRICE:
                $this->EnjoyRideObject->duration = Duration::TWO_DAY_PRICE;
                return true;
            case Duration::THREE_DAY_PRICE:
                $this->EnjoyRideObject->duration = Duration::THREE_DAY_PRICE;
                return true;
            case Duration::FOUR_DAY_PRICE:
                $this->EnjoyRideObject->duration = Duration::FOUR_DAY_PRICE;
                return true;
            case Duration::FIVE_DAY_PRICE:
                $this->EnjoyRideObject->duration = Duration::FIVE_DAY_PRICE;
                return true;
            case Duration::WEEKEND_PRICE:
                $this->EnjoyRideObject->duration = Duration::WEEKEND_PRICE;
                return true;
            case Duration::HALF_HOUR_PRICE:
                $this->EnjoyRideObject->duration = Duration::HALF_HOUR_PRICE;
                return true;
            case Duration::HOUR_PRICE:
                $this->EnjoyRideObject->duration = Duration::HOUR_PRICE;
                return true;
            default: 
                return false;
        }
    }

    private function getDelivery($delivery) {
        switch ($delivery) {
            case Delivery::BRNO:
                $this->EnjoyRideObject->delivery = Delivery::BRNO;
                return true;
            case Delivery::OLOMOUC:
                $this->EnjoyRideObject->delivery = Delivery::OLOMOUC;
                return true;
            case Delivery::OSTRAVA:
                $this->EnjoyRideObject->delivery = Delivery::OSTRAVA;
                return true;
            default: 
                return false;
        }
    }

    private function getDeliveryMethod($deliveryMethod) {
        switch ($deliveryMethod) {
            case DeliveryMethod::EMAIL:
                $this->EnjoyRideObject->deliveryMethod = DeliveryMethod::EMAIL;
                return true;
            case DeliveryMethod::VOUCHER:
                $this->EnjoyRideObject->deliveryMethod = DeliveryMethod::VOUCHER;
                return true;
            default: 
                return false;
        }
    }

    private function sendEmail() {
        $to = $this->EnjoyRideObject->customerEmail;
        $subject = "Objednávka přijata";
        $message = $this->generateMessage($this->databaseQuery->getCode());
        $headers = "from: info@topspeedbrno.cz \n";
        $headers .= "X-mailer: phpWebmail \n";
        
        if (mail($to, $subject, $message, $headers)) {
        } else {
            echo "CHYBA MAIL - odeslání se nepovedlo";
            return false;
        }

        $to = "info@topspeedbrno.cz";
        $subject = "Objednávka pro" .$this->EnjoyRideObject->customerName;
        $message = "Objednávka přijata";
        $headers = "from: info@topspeedbrno.cz \n";
        $headers .= "X-mailer: phpWebmail \n";
        
        if (mail($to, $subject, $message, $headers)) {
        } else {
            echo "CHYBA MAIL - odeslání se nepovedlo";
            return false;
        }

        return true;
    }

    private function generateMessage($code) {
        $message = "Objednávka přijata \n";
        $message .= "Byl vám vygenerován kód:" .$code; 
        return $message;
    }
}
?>