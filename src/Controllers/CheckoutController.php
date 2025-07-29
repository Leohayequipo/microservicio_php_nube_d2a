<?php
namespace App\Controllers;

use App\Services\CheckoutService;

class CheckoutController {
    private $service;

    public function __construct() {
        $this->service = new CheckoutService();
    }

    public function receive() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            return;
        }

        $this->service->processCheckout($data);
        echo json_encode(['status' => 'ok']);
    }
}
