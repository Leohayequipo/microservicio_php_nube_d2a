<?php
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../src/Config/bootstrap.php';

use App\Controllers\CheckoutController;
use App\Controllers\WebhookController;
use App\Controllers\D2AController;

$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/checkout-temp') !== false) {
    (new CheckoutController())->receive();
} elseif (strpos($requestUri, '/webhook') !== false) {
    (new WebhookController())->receive();
} elseif (strpos($requestUri, '/d2a/register') !== false) {
    (new D2AController())->register();
} elseif (strpos($requestUri, '/d2a/test') !== false) {
    (new D2AController())->test();
} elseif (strpos($requestUri, '/docs') !== false) {
    include __DIR__ . '/docs.php';
} elseif (strpos($requestUri, '/swagger') !== false) {
    include __DIR__ . '/swagger.php';
} elseif (strpos($requestUri, '/health') !== false) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'ok',
        'timestamp' => date('c'),
        'environment' => config('environment'),
        'version' => '1.0.0'
    ]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}
