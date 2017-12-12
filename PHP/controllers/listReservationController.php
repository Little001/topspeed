<?php
require_once('PHP/databaseQuery.php');

class ListReservationController {
    public $errors = "";
    public $list;
    private $date = "";
    private $databaseQuery;

    public function ListReservationController($GET) {
        $this->databaseQuery = new DataBaseQuery();

        if ($this->checkData($GET)) {
            $this->list = $this->databaseQuery->getReservation($this->date);
        } else {
            echo "list reservation data" . $this->errors;
        }
    }

    private function checkData ($GET) {
        if ((!isset ($GET["date"])) || (strlen($GET["date"]) < 1)) {
            $this->errors .= "date ";
            return false;    
        }
        $this->date = $GET["date"];

        return true;
    }
}
?>