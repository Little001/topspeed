<?php
require_once('PHP/models/enjoyRide.php');
require_once('PHP/databaseQuery.php');
require_once('PHP/enums.php');
require_once('PHP/controllers/enumsController.php');

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
        if (!EnumsController::getPayMethod($this->EnjoyRideObject, $POST["payMethod"])) {
            $this->errors .= "payMethod enums";
            return false;
        }

        //duration
        if (!(isset ($POST["duration"]))) {
            $this->errors .= "duration ";
            return false;    
        }
        if (!EnumsController::getDuration($this->EnjoyRideObject ,$POST["duration"])) {
            $this->errors .= "duration enums";
            return false;
        }

        //delivery
        if (!(isset ($POST["delivery"]))) {
            $this->errors .= "delivery ";
            return false;    
        }
        if (!EnumsController::getDelivery($this->EnjoyRideObject ,$POST["delivery"])) {
            $this->errors .= "delivery enums";
            return false;
        }

        //delivery method
        if (!(isset ($POST["deliveryMethod"]))) {
            $this->errors .= "deliveryMethod ";
            return false;    
        }
        if (!EnumsController::getDeliveryMethod($this->EnjoyRideObject ,$POST["deliveryMethod"])) {
            $this->errors .= "deliveryMethod enums";
            return false;
        }

        return true;
    }

    private function sendEmail() {
        $to = $this->EnjoyRideObject->customerEmail;
        $subject = "Objednávka přijata";
        $message = $this->generateMessage($this->databaseQuery->lastId, $this->databaseQuery->getCode());
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

    private function generateMessage($id, $code) {
        $durationPrice = EnumsController::getDurationPrice($this->EnjoyRideObject->duration);
        $deliveryMethodPrice = EnumsController::getDeliveryMethodPrice($this->EnjoyRideObject->deliveryMethod);
        $price = $durationPrice + $deliveryMethodPrice;
        $message = "Vážený zákazníku, \n \n";
        $message .= "Vaše objednávka číslo: " . $id . ", na-shopu www.topspeedbrno.cz byla přijata \n"; 
        $message .= "Rekapitulace Vaší objednávky: \n"; 
        $message .= "Položka \n"; 
        $message .= "Zážitková jízda " . EnumsController::getDurationText($this->EnjoyRideObject->duration) . " "; 
        $message .=  $durationPrice. " Kč \n";
        $message .= "Způsob dopravy: " . EnumsController::getDeliveryMethodText($this->EnjoyRideObject->deliveryMethod) . " "; 
        $message .= $deliveryMethodPrice . " Kč \n";
        $message .= "Celkem " . $price . "Kč \n\n"; 
        $message .= "Nástupní místo: " . EnumsController::getDeliveryText($this->EnjoyRideObject->delivery) . "\n"; 
        $message .= "Metoda platby: " . EnumsController::getPayMethodText($this->EnjoyRideObject->payMethod) . "\n\n"; 
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