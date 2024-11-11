<?php
require_once '../vendor/autoload.php';

use App\Controllers\AssociateAnnuitiesController;
use App\Controllers\AssociateController;
use App\Controllers\AnnuityController;
use App\Models\Associates;
use App\Models\Annuities;
use App\Models\AssociatedAnnuities;

try {
    $pdo = new PDO('pgsql:host=localhost;dbname=annuity_management', 'postgres', 'admin');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    Associates::setConnection($pdo); 
    Annuities::setConnection($pdo);
    AssociatedAnnuities::setConnection($pdo);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}


$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = str_replace('/devs_rn', '', $requestUri);  

$requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

$associateController = new AssociateController();
$annuityController = new AnnuityController();
$associateAnnuitiesController = new AssociateAnnuitiesController();

switch ($requestUri) {
    case '/associates/create':
        if ($requestMethod === 'GET') {
            $associateController->create_associates();
        }
        break;
    case '/home':
        $associateController->index();
        break;
    case '/associates':
        $associateController->show_associates();
        break;
    case '/annuities':
        $annuityController->show_annuities();
        break;
    case '/annuities/create':
        $annuityController->create_annuities();
        break;
    case '/associates/store':
        if ($requestMethod === 'POST') {
            $associateController->store_associated($_POST);
        }
        break;
    case '/associates/delete':
        if ($requestMethod === 'POST') {
            $associateController->delete_associated($_POST);
        }
        break;
    case '/associates/update':
        if (isset($_GET['id'])) {
            $associateController->update_associated($_GET['id']);
        }
        break;
    case '/associates/refresh':
        if ($requestMethod === 'POST') {
            $associateController->refresh_associated($_POST);
        }
        break;
    case '/associates/checkout':
        if (isset($_GET['id'])) {
            $associateAnnuitiesController->checkout_associated($_GET['id']);
        }
        break;
    case '/associated/payment':
        if ($requestMethod === 'POST') {
            $associateAnnuitiesController->pay_annuity($_POST);
        }
    case '/associated/pay_all':
        if ($requestMethod === 'POST') {
            $associateAnnuitiesController->pay_all_annuities($_POST);
        }
    case '/annuities/store':
        if ($requestMethod === 'POST') {
            $annuityController->store_annuities($_POST);
        }
        break;
    case '/annuities/delete':
        if ($requestMethod === 'POST') {
            $annuityController->delete_annuity($_POST);
        }
        break;
    case '/annuities/update':
        if (isset($_GET['id'])) {
            $annuityController->update_annuity($_GET['id']);
        }
        break;
    case '/annuities/refresh':
        if ($requestMethod === 'POST') {
            $annuityController->refresh_annuities($_POST);
        }
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        break;
}

