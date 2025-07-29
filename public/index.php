<?php
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../src/Config/bootstrap.php';

use App\Controllers\CheckoutController;
use App\Controllers\WebhookController;

$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/checkout-temp') !== false) {
    (new CheckoutController())->receive();
} elseif (strpos($requestUri, '/webhook') !== false) {
    (new WebhookController())->receive();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}
