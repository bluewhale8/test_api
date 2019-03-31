<?php

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'Api.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header('Content-Type: application/json');

$api = new Api();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    
    case 'GET':
        if (isset($_GET['key'])) {
            echo $api->get($_GET['key']);
        }
        break;
        
    case 'POST':
        if (isset($_POST['key']) && isset($_POST['value'])) {
            echo $api->post($_POST['key'], $_POST['value']);
        }
        break;
        
    case 'DELETE':
        parse_str(file_get_contents('php://input'), $params);
        if (isset($params['key'])) {
            echo $api->delete($params['key']);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['error' => "wrong method"]);
}


