<?php
require_once('PHP/databaseQuery.php');
require_once('PHP/models/checkCode.php');
require_once('PHP/models/checkCode.php');

class CheckCodeController {
    public $errors = "";
    private $databaseQuery;
    public $CheckCodeObject;
    private $code;
    private $id_order;
    private $method;

    public function CheckCodeController($GET) {
        $this->databaseQuery = new DataBaseQuery();
        $this->CheckCodeObject = new CheckCode();

        if ($this->checkData($GET)) {
            $this->CheckCodeObject = $this->databaseQuery->getCodeInformation($this->id_order, $this->method);
        } else {
            echo "get positions data" . $this->errors;
        }
    }

    private function checkData ($GET) {
        if ((!isset ($GET["code"])) || (strlen($GET["code"]) < 1)) {
            $this->errors .= "code ";
            return false;    
        }
        $ride = $this->databaseQuery->getRideByCode($GET["code"]);
        if ($ride == false) {
            $this->errors .= "code not exists ";
            return false;
        }
        $this->id_order = $ride["id_order"];
        $this->method = $ride["method"];
        $this->code = $GET["code"];

        return true;
    }
}
?>