<?php
require_once('PHP/databaseQuery.php');
require_once('PHP/models/position.php');

class LocationListController {
    public $errors = "";
    public $list;
    private $month_year = "";
    private $databaseQuery;

    public function LocationListController($GET) {
        $this->databaseQuery = new DataBaseQuery();

        if ($this->checkData($GET)) {
            $this->list = $this->databaseQuery->getPositions($this->month_year);
        } else {
            echo "get positions data" . $this->errors;
        }
    }

    private function checkData ($GET) {
        if ((!isset ($GET["month_year"]))) {
            $this->errors .= "month_year ";
            return false;    
        }
        $this->month_year = $GET["month_year"];

        return true;
    }
}

class LocationSetController {
    public $errors = "";
    private $locationModel;
    private $databaseQuery;

    public function LocationSetController($POST) {
        $this->databaseQuery = new DataBaseQuery();
        $this->locationModel = new LocationModel();
        
        if ($this->checkData($POST)) { 
            if ($this->databaseQuery->setPositions($this->locationModel)) {
            } else {
                $this->errors .= "set location";
            }
        } else {
            echo "set location data-" . $this->errors;
        }
    }


    private function checkData ($POST) {
        if ((!isset ($POST["month_year"]))) {
            $this->errors .= "month_year ";
            return false;    
        }
        $this->locationModel->month = $POST["month_year"];

        if ((!isset ($POST["rows"]))) {
            $this->errors .= "rows ";
            return false;    
        }
        $this->locationModel->rows = $POST["rows"];

        return true;
    }
}
?>