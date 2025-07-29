<?php
namespace App\Services;

class D2AService {
    private $apiUrl;

    public function __construct() {
        // Podés mover esto a config.php
        $this->apiUrl = "https://api.d2a.com/event";
    }

    public function sendEvent(array $payload): bool {
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Log simple para debug
        file_put_contents(__DIR__."/../../storage/logs/d2a.log", date('c')." ".json_encode($payload)." STATUS:$status\n", FILE_APPEND);

        return $status === 200;
    }
}
