<?php
require_once('PHP/controllers/hireRideController.php');
require_once('PHP/controllers/enjoyRideController.php');
header('Content-Type: application/json');
$apiArgArray = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
$returnObject = (object) array();
$route = request_path();

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    $returnObject = $newobj;
    $object;
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
                echo "OK";
            }
            break;
        case "hire":
            $object = new HireRideController($_POST);
            if (strlen($object->errors) > 0) {
                header('HTTP/1.1 400 Bad request', true, 400);
            } else {
                echo "OK";
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