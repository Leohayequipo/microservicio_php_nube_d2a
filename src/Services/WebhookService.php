<?php
namespace App\Services;

class WebhookService {
    private $d2aService;

    public function __construct() {
        $this->d2aService = new D2AService();
    }

    public function processWebhook(array $data): void {
        $event = $data['event'] ?? '';
        
        switch ($event) {
            case 'order/created':
                $this->handleOrderCreated($data);
                break;
            case 'order/paid':
                $this->handleOrderPaid($data);
                break;
            default:
                $this->logEvent('webhook_ignorado', $data);
                break;
        }
    }

    private function handleOrderCreated(array $data): void {
        $checkoutId = $data['checkout']['id'] ?? null;
        
        if (!$checkoutId) {
            $this->logEvent('error_checkout_id_faltante', $data);
            return;
        }

        // Buscar datos del checkout guardados
        $checkoutFile = __DIR__ . "/../../storage/tmp/checkout_{$checkoutId}.json";
        
        if (!file_exists($checkoutFile)) {
            $this->logEvent('error_checkout_no_encontrado', ['checkout_id' => $checkoutId]);
            return;
        }

        $checkoutData = json_decode(file_get_contents($checkoutFile), true);
        
        // Combinar datos del checkout con datos del webhook
        $eventData = [
            'event_type' => 'checkout_confirmado',
            'order_id' => $data['id'],
            'checkout_id' => $checkoutId,
            'store_id' => $data['store_id'] ?? $checkoutData['store_id'],
            'payment' => array_merge(
                $checkoutData['payment'] ?? [],
                $data['payment_details'] ?? []
            ),
            'cart' => $checkoutData['cart'] ?? [],
            'customer' => $data['customer'] ?? [],
            'timestamp' => date('c')
        ];

        $this->d2aService->sendEvent($eventData);
        $this->logEvent('checkout_confirmado', $eventData);
    }

    private function handleOrderPaid(array $data): void {
        $eventData = [
            'event_type' => 'pago_aprobado',
            'order_id' => $data['id'],
            'store_id' => $data['store_id'] ?? null,
            'timestamp' => date('c')
        ];

        $this->d2aService->sendEvent($eventData);
        $this->logEvent('pago_aprobado', $eventData);
    }

    private function logEvent(string $eventType, array $data): void {
        $logFile = __DIR__ . "/../../storage/logs/webhooks.log";
        $logEntry = date('c') . " [{$eventType}] " . json_encode($data) . "\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
