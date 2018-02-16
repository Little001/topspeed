<?php
require_once('PHP/controllers/hireRideController.php');
require_once('PHP/controllers/enjoyRideController.php');
require_once('PHP/controllers/contactController.php');
require_once('PHP/controllers/reservationController.php');
require_once('PHP/controllers/listReservationController.php');
require_once('PHP/controllers/locationController.php');
require_once('PHP/controllers/checkCodeController.php');
$apiArgArray = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
$returnObject = (object) array();
$route = request_path();

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    switch($route) {
        case "reservation":
            $object = new ListReservationController($_GET);
            if (strlen($object->errors) > 0) {
                header('HTTP/1.1 400 Bad request', true, 400);
            } else {
                echo $object->list;
                header('HTTP/1.1 200 Bad request', true, 200);
            }
            break;
        case "position":
            $object = new LocationListController($_GET);
            if (strlen($object->errors) > 0) {
                header('HTTP/1.1 400 Bad request', true, 400);
            } else {
                echo json_encode($object->list);
                header('HTTP/1.1 200 Bad request', true, 200);
            }
            break;
        case "checkCode":
            $object = new CheckCodeController($_GET);
            if (strlen($object->errors) > 0) {
                header('HTTP/1.1 400 Bad request', true, 400);
            } else {
                echo json_encode($object->CheckCodeObject);
                header('HTTP/1.1 200 Bad request', true, 200);
            }
            break;
        }
    break;
  case 'PUT':       
    // Replace entire collection or member
    break;  
  case 'POST':
    switch($route) {
        case "enjoy":
            $object = new EnjoyRideController($_POST);
            if (strlen($object->errors) > 0) {
                header('HTTP/1.1 400 Bad request', true, 400);
            } else {
                echo json_encode($object->databaseQuery->response);
                header('HTTP/1.1 200 Bad request', true, 200);
            }
            break;
        case "hire":
            $object = new HireRideController($_POST);
            if (strlen($object->errors) > 0) {
                header('HTTP/1.1 400 Bad request', true, 400);
            } else {
                echo json_encode($object->databaseQuery->response);
                header('HTTP/1.1 200 Bad request', true, 200);
            }
            break;
        case "reservation":
            $object = new ReservationController($_POST);
            if (strlen($object->errors) > 0) {
                header('HTTP/1.1 400 Bad request', true, 400);
            } else {
                header('HTTP/1.1 200 Bad request', true, 200);
            }
            break;
        case "position":
            $object = new LocationSetController($_POST);
            if (strlen($object->errors) > 0) {
                header('HTTP/1.1 400 Bad request', true, 400);
            } else {
                header('HTTP/1.1 200 Bad request', true, 200);
            }
            break;
        case "contact":
            $object = new ContactController($_POST);
            if (strlen($object->errors) > 0) {
                header('HTTP/1.1 400 Bad request', true, 400);
            } else {
                header('HTTP/1.1 200 Bad request', true, 200);
            }
            break;
        default:
            $returnObject = "fail";
    }
    break;
  case 'DELETE':    
    // Delete collection or member
    break;
}

function request_path()
{
    $request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    $script_name = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
    $parts = array_diff_assoc($request_uri, $script_name);
    if (empty($parts))
    {
        return '/';
    }
    $path = implode('/', $parts);
    if (($position = strpos($path, '?')) !== FALSE)
    {
        $path = substr($path, 0, $position);
    }
    return $path;
}


?>