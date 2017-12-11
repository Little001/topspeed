<?php
require_once('PHP/models/hireRide.php');
require_once('PHP/databaseQuery.php');
require_once('PHP/enums.php');

class HireRideController {
    public $errors = "";
    private $HireRideObject;

    public function HireRideController($POST) {
        $this->HireRideObject = new HireRide();
        $databaseQuery = new DataBaseQuery();
        if ($this->checkData($POST)) {
            if ($databaseQuery->insertHireRide($this->HireRideObject)) {
                $this->sendEmail();
            }
        } else {
            echo "fail data" . $this->errors;
        }
    }

    private function checkData ($POST) {
        if ((!isset ($POST["street"])) || (strlen($POST["street"]) < 1)) {
            $this->errors .= "street ";
            return false;
        }
        $this->HireRideObject->street = $POST["street"];

        if ((!isset ($POST["city"])) || (strlen($POST["city"]) < 1)) {
            $this->errors .= "city ";
            return false;
        }
        $this->HireRideObject->city = $POST["city"];

        if ((!isset ($POST["psc"])) || (strlen($POST["psc"]) < 1)) {
            $this->errors .= "psc ";
            return false;    
        }
        $this->HireRideObject->psc = $POST["psc"];

        if ((!isset ($POST["customerName"])) || (strlen($POST["customerName"]) < 1)) {
            $this->errors .= "customerName ";
            return false;    
        }
        $this->HireRideObject->customerName = $POST["customerName"];

        if ((!isset ($POST["customerStreet"])) || (strlen($POST["customerStreet"]) < 1)) {
            $this->errors .= "customerStreet ";
            return false;    
        }
        $this->HireRideObject->customerStreet = $POST["customerStreet"];

        if ((!isset ($POST["customerCity"])) || (strlen($POST["customerCity"]) < 1)) {
            $this->errors .= "customerCity ";
            return false;    
        }
        $this->HireRideObject->customerCity = $POST["customerCity"];

        if ((!isset ($POST["customerPsc"])) || (strlen($POST["customerPsc"]) < 1)) {
            $this->errors .= "customerPsc ";
            return false;    
        }
        $this->HireRideObject->customerPsc = $POST["customerPsc"];

        //email
        if ((!isset ($POST["customerEmail"])) || (strlen($POST["customerEmail"]) < 1)) {
            $this->errors .= "customerEmail ";
            return false;    
        }
        if (!filter_var($POST["customerEmail"], FILTER_VALIDATE_EMAIL)) {
            $this->errors .= "customerEmail ";
            return false;
        }
        $this->HireRideObject->customerEmail = $POST["customerEmail"];

        if ((!isset ($POST["customerPhone"])) || (strlen($POST["customerPhone"]) < 1)) {
            $this->errors .= "customerPhone ";
            return false;    
        }
        $this->HireRideObject->customerPhone = $POST["customerPhone"];

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
                $this->HireRideObject->payMethod = PayMethod::BankAccount;
                return true;
            case PayMethod::CashOnDelivery:
                $this->HireRideObject->payMethod = PayMethod::CashOnDelivery;
                return true;
            default: 
                return false;
        }
    }

    private function getDuration($duration) {
        switch ($duration) {
            case Duration::TWELVE_HOURS_PRICE:
                $this->HireRideObject->duration = Duration::TWELVE_HOURS_PRICE;
                return true;
            case Duration::ONE_DAY_PRICE:
                $this->HireRideObject->duration = Duration::ONE_DAY_PRICE;
                return true;
            case Duration::TWO_DAY_PRICE:
                $this->HireRideObject->duration = Duration::TWO_DAY_PRICE;
                return true;
            case Duration::THREE_DAY_PRICE:
                $this->HireRideObject->duration = Duration::THREE_DAY_PRICE;
                return true;
            case Duration::FOUR_DAY_PRICE:
                $this->HireRideObject->duration = Duration::FOUR_DAY_PRICE;
                return true;
            case Duration::FIVE_DAY_PRICE:
                $this->HireRideObject->duration = Duration::FIVE_DAY_PRICE;
                return true;
            case Duration::WEEKEND_PRICE:
                $this->HireRideObject->duration = Duration::WEEKEND_PRICE;
                return true;
            case Duration::HALF_HOUR_PRICE:
                $this->HireRideObject->duration = Duration::HALF_HOUR_PRICE;
                return true;
            case Duration::HOUR_PRICE:
                $this->HireRideObject->duration = Duration::HOUR_PRICE;
                return true;
            default: 
                return false;
        }
    }

    private function getDelivery($delivery) {
        switch ($delivery) {
            case Delivery::BRNO:
                $this->HireRideObject->delivery = Delivery::BRNO;
                return true;
            case Delivery::OLOMOUC:
                $this->HireRideObject->delivery = Delivery::OLOMOUC;
                return true;
            case Delivery::OSTRAVA:
                $this->HireRideObject->delivery = Delivery::OSTRAVA;
                return true;
            default: 
                return false;
        }
    }

    private function getDeliveryMethod($deliveryMethod) {
        switch ($deliveryMethod) {
            case DeliveryMethod::EMAIL:
                $this->HireRideObject->deliveryMethod = DeliveryMethod::EMAIL;
                return true;
            case DeliveryMethod::VOUCHER:
                $this->HireRideObject->deliveryMethod = DeliveryMethod::VOUCHER;
                return true;
            default: 
                return false;
        }
    }

    private function sendEmail() {
        
        $to = $this->HireRideController->customerEmail;
        $subject = "Objednávka přijata";
        $txt = "Objednávka přijata";
        $headers = "From: info@topspeedbrno.cz";
        
        mail($to,$subject,$txt,$headers);

        $to = "info@topspeedbrno.cz";
        $subject = "Objednávka přijata";
        $txt = "Objednávka přijata";
        $headers = "From: info@topspeedbrno.cz";
        
        mail($to,$subject,$txt,$headers);
    }
}
?>