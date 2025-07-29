<?php
namespace App\Controllers;

use App\Services\WebhookService;

class WebhookController {
    private $service;

    public function __construct() {
        $this->service = new WebhookService();
    }

    public function receive() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            return;
        }

        $this->service->processWebhook($data);
        echo json_encode(['status' => 'ok']);
    }
}
