<?php
namespace App\Services;

class D2AService {
    private $apiKey;
    private $apiSecret;
    private $environment;
    private $customer;
    private $apiUrl;

    public function __construct() {
        // Cargar configuración de D2A
        $config = require __DIR__ . '/../../config/d2a.php';
        
        $this->apiKey = $config['api_key'];
        $this->apiSecret = $config['api_secret'];
        $this->environment = $config['environment'];
        $this->customer = $config['customer_id'];
        $this->apiUrl = $config['api_url'];
        
        // Verificar que las credenciales estén configuradas
        if ($this->apiKey === 'TU_API_KEY' || $this->apiSecret === 'TU_API_SECRET' || $this->customer === 'TU_CUSTOMER_ID') {
            error_log("D2A API Error: Credenciales no configuradas. Revisar config/d2a.php");
        }
    }

    public function sendEvent(array $payload): bool {
        // Crear el objeto de tracking según la implementación de D2A
        $track = [
            'cs' => $this->customer,
            'abuVer' => 'APIV1.1',
            'ts' => date('c'),
            'tz' => date('P'),
            'sessionName' => $payload['sessionName'] ?? '',
            'visitorName' => $payload['visitorName'] ?? '',
            'registrant' => $payload['registrant'] ?? '',
            'operation' => $payload['operation'] ?? '',
            'ApiKey' => $this->apiKey,
            'hs' => $this->generateHash($payload['operation'] ?? ''),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? ''
        ];

        // Crear el mensaje completo según formato D2A
        $message = [
            'track' => $track,
            'ms' => $payload['data'] ?? $payload
        ];

        // Preparar el payload para envío
        $fields = [
            'data' => json_encode($message)
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_USERAGENT, "d2a API");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Log detallado para debug
        $logEntry = [
            'timestamp' => date('c'),
            'url' => $this->apiUrl,
            'payload' => $message,
            'response' => $response,
            'status' => $status,
            'error' => $error
        ];
        
        file_put_contents(
            __DIR__."/../../storage/logs/d2a.log", 
            json_encode($logEntry, JSON_PRETTY_PRINT) . "\n---\n", 
            FILE_APPEND
        );

        if ($error) {
            error_log("D2A API Error: " . $error);
            return false;
        }

        // Verificar respuesta según formato D2A
        $result = json_decode($response, true);
        if ($result && isset($result['track']['rc'])) {
            return $result['track']['rc'] === 'OK';
        }

        return $status === 200;
    }

    /**
     * Genera el hash de autenticación según la implementación de D2A
     */
    private function generateHash($operation): string {
        $string = $this->apiKey . $this->apiSecret . $this->customer . ($operation ?? '');
        return md5($string);
    }

    /**
     * Registra un cliente en D2A (Checkout)
     * Se ejecuta cuando se cargan los datos del cliente en el checkout
     * 
     * @param array $data - Datos del cliente según especificación ABU_registration
     * @return bool
     */
    public function registerCustomer(array $data): bool {
        // Validar datos requeridos
        $requiredFields = [
            'registrant', 'typeOfId', 'nationalId', 'name', 'lastName', 
            'gender', 'age', 'email', 'cellphone', 'city', 'state', 
            'country', 'address1', 'totalInCart', 'totalBought'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                error_log("D2A Registration Error: Campo requerido '$field' faltante");
                return false;
            }
        }

        // Crear el payload según el formato de d2aRegistration
        $registrationData = [
            'track' => '',
            'registrant' => $data['registrant'],
            'typeOfId' => $data['typeOfId'],
            'nationalId' => $data['nationalId'],
            'name' => $data['name'],
            'lastName' => $data['lastName'],
            'gender' => $data['gender'],
            'age' => (int)$data['age'],
            'email' => $data['email'],
            'cellphone' => $data['cellphone'],
            'facebookId' => $data['facebookId'] ?? '',
            'instagramId' => $data['instagramId'] ?? '',
            'twitterId' => $data['twitterId'] ?? '',
            'linkedinId' => $data['linkedinId'] ?? '',
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'address1' => $data['address1'],
            'address2' => $data['address2'] ?? '',
            'companyName' => '',
            'companyCustomer' => ''
        ];

        // Preparar el payload para envío
        $payload = [
            'operation' => 'registration',
            'registrant' => $data['registrant'],
            'sessionName' => $data['sessionName'] ?? '',
            'visitorName' => $data['visitorName'] ?? '',
            'data' => $registrationData
        ];

        return $this->sendEvent($payload);
    }
}
