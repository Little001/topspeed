<?php

class ContactController {
    public $errors = "";
    private $name = "";
    private $email = "";
    private $question = "";

    public function ContactController($POST) {
        if ($this->checkData($POST)) {
            if(!$this->sendEmail()) {
                $this->errors .= "send email ERROR";
            }
        } else {
            echo "contact data" . $this->errors;
        }
    }

    private function sendEmail() {
        $to = "info@topspeedbrno.cz";
        $subject = "Někdo vás kontaktuje";
        $message = $this->question;
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
        if ((!isset ($POST["name"])) || (strlen($POST["name"]) < 1)) {
            $this->errors .= "name ";
            return false;    
        }
        $this->name = $POST["name"];

        //email
        if ((!isset ($POST["email"])) || (strlen($POST["email"]) < 1)) {
            $this->errors .= "email ";
            return false;    
        }
        if (!filter_var($POST["email"], FILTER_VALIDATE_EMAIL)) {
            $this->errors .= "email ";
            return false;
        }
        $this->email = $POST["email"];

        if ((!isset ($POST["question"])) || (strlen($POST["question"]) < 1)) {
            $this->errors .= "question ";
            return false;    
        }
        $this->question = $POST["question"];

        return true;
    }
}
?>