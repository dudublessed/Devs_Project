<?php
require_once '../vendor/autoload.php';

use App\Controllers\AssociateController;
use App\Models\Associates;

$pdo = new PDO('pgsql:host=localhost;dbname=annuity_management', 'postgres', 'admin');
Associates::setConnection($pdo); 


$requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$requestUri = str_replace('/devs_rn', '', $requestUri);  

$requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

$controller = new AssociateController();

if ($requestUri === '/home') {
    $controller->index(); 
} elseif ($requestUri === '/associates/create') {
    $controller->create(); 
} elseif ($requestMethod === 'POST' && $requestUri === '/associates/store') {
    $controller->store($_POST);
} else {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";  
}
