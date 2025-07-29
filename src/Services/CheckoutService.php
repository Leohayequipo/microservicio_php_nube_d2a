<?php
namespace App\Services;

use App\Repositories\CheckoutRepository;
use App\Services\D2AService;

class CheckoutService {
    private $d2aService;

    public function __construct() {
        $this->d2aService = new D2AService();
    }

    public function processCheckout(array $data): void {
        // Guardar datos del checkout temporalmente
        $checkoutId = $data['checkout_id'] ?? uniqid();
        $filename = __DIR__ . "/../../storage/tmp/checkout_{$checkoutId}.json";
        
        // Crear directorio si no existe
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));

        // Enviar evento a D2A
        $eventData = [
            'event_type' => 'checkout_iniciado',
            'checkout_id' => $checkoutId,
            'store_id' => $data['store_id'] ?? null,
            'payment' => $data['payment'] ?? [],
            'cart' => $data['cart'] ?? [],
            'timestamp' => date('c')
        ];

        $this->d2aService->sendEvent($eventData);
        
        // Log del evento
        $this->logEvent('checkout_iniciado', $eventData);
    }

    private function logEvent(string $eventType, array $data): void {
        $logFile = __DIR__ . "/../../storage/logs/webhooks.log";
        $logEntry = date('c') . " [{$eventType}] " . json_encode($data) . "\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
