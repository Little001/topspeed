<?php
require_once('PHP/models/hireRide.php');
require_once('PHP/databaseQuery.php');
require_once('PHP/enums.php');
require_once('PHP/controllers/enumsController.php');

class HireRideController {
    public $errors = "";
    public $databaseQuery;
    private $HireRideObject;

    public function HireRideController($POST) {
        $this->HireRideObject = new HireRide();
        $this->databaseQuery = new DataBaseQuery();
        if ($this->checkData($POST)) {
            if ($this->databaseQuery->insertHireRide($this->HireRideObject)) {
                if (!$this->sendEmail()) {
                    $this->errors .= "send email ERROR";
                }
            } else {
                $this->errors .= "insert hire ride";
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
        if (!EnumsController::getPayMethod($this->HireRideObject, $POST["payMethod"])) {
            $this->errors .= "payMethod enums";
            return false;
        }

        //duration
        if (!(isset ($POST["duration"]))) {
            $this->errors .= "duration ";
            return false;    
        }
        if (!EnumsController::getDuration($this->HireRideObject ,$POST["duration"])) {
            $this->errors .= "duration enums";
            return false;
        }

        //delivery
        if (!(isset ($POST["delivery"]))) {
            $this->errors .= "delivery ";
            return false;    
        }
        if (!EnumsController::getDelivery($this->HireRideObject ,$POST["delivery"])) {
            $this->errors .= "delivery enums";
            return false;
        }

        //delivery method
        if (!(isset ($POST["deliveryMethod"]))) {
            $this->errors .= "deliveryMethod ";
            return false;    
        }
        if (!EnumsController::getDeliveryMethod($this->HireRideObject ,$POST["deliveryMethod"])) {
            $this->errors .= "deliveryMethod enums";
            return false;
        }

        return true;
    }

    private function sendEmail() {
        $to = $this->HireRideObject->customerEmail;
        $subject = "Objednávka přijata";
        $message = $this->generateMessage($this->databaseQuery->lastID, $this->databaseQuery->getCode());
        $headers = "from: info@topspeedbrno.cz \n";
        $headers .= "X-mailer: phpWebmail \n";
        
        if (mail($to, $subject, $message, $headers)) {
        } else {
            echo "CHYBA MAIL - odeslání se nepovedlo";
            return false;
        }

        $to = "info@topspeedbrno.cz";
        $subject = "Objednávka pro" .$this->HireRideObject->customerName;
        $message = "Objednávka text...";
        $headers = "from: info@topspeedbrno.cz \n";
        $headers .= "X-mailer: phpWebmail \n";
        
        if (mail($to, $subject, $message, $headers)) {
        } else {
            echo "CHYBA MAIL - odeslání se nepovedlo";
            return false;
        }

        return true;
    }

    private function generateMessage($id, $code) {
        $durationPrice = EnumsController::getDurationPrice($this->HireRideObject->duration);
        $deliveryMethodPrice = EnumsController::getDeliveryMethodPrice($this->HireRideObject->deliveryMethod);
        $price = $durationPrice + $deliveryMethodPrice;
        $message = "Vážený zákazníku, \n \n";
        $message .= "Vaše objednávka číslo: " . $id . ", na-shopu www.topspeedbrno.cz byla přijata \n"; 
        $message .= "Vaš kód pro rezervaci je: " . $code . "\n"; 
        $message .= "Rekapitulace Vaší objednávky: \n"; 
        $message .= "Pronájem vozu " . EnumsController::getDurationText($this->HireRideObject->duration) . " "; 
        $message .=  $durationPrice. " Kč \n";
        $message .= "Způsob dopravy: " . EnumsController::getDeliveryMethodText($this->HireRideObject->deliveryMethod) . " "; 
        $message .= $deliveryMethodPrice . " Kč \n";
        $message .= "Celkem " . $price . "Kč \n\n"; 
        $message .= "Nástupní místo: " . EnumsController::getDeliveryText($this->HireRideObject->delivery) . "\n"; 
        $message .= "Metoda platby: " . EnumsController::getPayMethodText($this->HireRideObject->payMethod) . "\n\n"; 
        $message .= "Fakturační adresa: \n";
        $message .= "Oldřich Ballák \n"; 
        $message .= "Novosady 557 \n"; 
        $message .= "Litovel \n"; 
        $message .= "78401 \n"; 
        $message .= "olda.ballak@seznam.cz \n";
        $message .= "735947016 \n\n"; 
        $message .= "Poznámka k objednávce: \n"; 
        $message .= "Bankovní spojení: 2101328979/2010 \n\n"; 
        $message .= "Těšíme se na Vás a přejeme pěkný zbytek dne, \n\n"; 
        $message .= "Topspeedbrno.cz"; 
        return $message;
    }
}
?>