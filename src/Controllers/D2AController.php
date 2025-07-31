<?php
namespace App\Controllers;

use App\Services\D2AService;

class D2AController {
    private $d2aService;

    public function __construct() {
        $this->d2aService = new D2AService();
    }

    /**
     * Endpoint para registrar cliente ABU (Checkout)
     * POST /d2a/register
     */
    public function register() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                throw new \Exception('Invalid JSON input');
            }

            $success = $this->d2aService->registerCustomer($input);

            if ($success) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'Customer registered successfully in D2A',
                    'timestamp' => date('c')
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Failed to register customer in D2A'
                ]);
            }

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Endpoint para probar conectividad con D2A
     * GET /d2a/test
     */
    public function test() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            return;
        }

        try {
            $d2aService = new D2AService();
            
            // Payload de prueba
            $testPayload = [
                'event' => 'ABU_test',
                'test' => true,
                'timestamp' => date('c'),
                'message' => 'Test de conectividad con D2A API'
            ];

            $success = $d2aService->sendEvent($testPayload);

            if ($success) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'Conexión exitosa con D2A API',
                    'timestamp' => date('c'),
                    'test_payload' => $testPayload
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Error al conectar con D2A API',
                    'timestamp' => date('c'),
                    'test_payload' => $testPayload
                ]);
            }

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => date('c')
            ]);
        }
    }
} 