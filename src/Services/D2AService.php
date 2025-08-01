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
        // Crear el objeto de tracking según la implementación exacta de D2A del usuario
        $track = [
            'cs' => $this->customer,
            'abuVer' => 'APIV1.1',
            'ts' => $payload['userTime'] ?? date('c'),
            'tz' => $payload['userTimeZone'] ?? date('P'),
            'sessionName' => $payload['sessionName'] ?? '',
            'visitorName' => $payload['visitorName'] ?? '',
            'registrant' => $payload['registrant'] ?? '',
            'operation' => $payload['operation'] ?? '',
            'ApiKey' => $this->apiKey,
            'hs' => $this->generateHash($payload['operation'] ?? '', $payload['registrant'] ?? ''),
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
            // Para D2A, rc=0 significa éxito, rc=1 significa error
            return $result['track']['rc'] === 0;
        }

        return $status === 200;
    }

    /**
     * Genera el hash de autenticación según la implementación de D2A
     */
    private function generateHash($operation, $registrant = ''): string {
        // Según el test simple que funciona, el hash se genera como:
        // ApiKey + ApiSecret + Customer + Registrant + Operation
        $string = $this->apiKey . $this->apiSecret . $this->customer . $registrant . $operation;
        return md5($string);
    }

    /**
     * Registra un cliente en D2A (Checkout)
     * Se ejecuta cuando se cargan los datos del cliente en el checkout
     * 
     * @param array $data - Datos del cliente según especificación ABU_registration
     * @param string $abuSession - JSON string del abu_session del frontend
     * @return bool
     */
    public function registerCustomer(array $data, string $abuSession = ''): bool {
        // Procesar abu_session si se proporciona
        $sessionData = [];
        if (!empty($abuSession)) {
            $abuArray = json_decode($abuSession, true);
            if ($abuArray && count($abuArray) >= 6) {
                $sessionData = [
                    'userTime' => $abuArray[1],
                    'userTimeZone' => $abuArray[2],
                    'sessionName' => str_replace('"', '', $abuArray[3]),
                    'visitorName' => str_replace('"', '', $abuArray[4]),
                    'registrant' => str_replace(']', '', str_replace('"', '', $abuArray[5]))
                ];
            }
        }

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

        // Usar la clase d2a exactamente como en la implementación original
        require_once __DIR__ . '/../../D2a2Api.php';
        
        $userTime = $sessionData['userTime'] ?? date('YmdHis');
        $userTimeZone = $sessionData['userTimeZone'] ?? '-0300';
        $sessionName = $sessionData['sessionName'] ?? 'session_' . time();
        $visitorName = $sessionData['visitorName'] ?? 'visitor_' . time();
        $registrantEmail = $sessionData['registrant'] ?? $data['registrant'];

        // Crear instancia de d2a exactamente como en tu implementación
        $conexion = new \d2a(
            $this->apiKey, 
            $this->apiSecret, 
            $this->environment, 
            $this->customer, 
            $sessionName, 
            $visitorName, 
            $registrantEmail, 
            "", "", "", 
            $userTime, 
            $userTimeZone
        );

        // Crear mensaje de registration exactamente como en tu implementación
        $msg = new \d2aRegistration(
            $registrantEmail,      // registrantId
            $data['typeOfId'],     // typeOfId
            $data['nationalId'],   // nationalId
            $data['name'],         // name
            $data['lastName'],     // lastName
            $data['gender'],       // gender
            $data['age'],          // age
            $data['email'],        // email
            $data['cellphone'],    // cellphone
            $data['facebookId'] ?? '',     // facebookId
            $data['instagramId'] ?? '',    // instagramId
            $data['twitterId'] ?? '',      // twitterId
            $data['linkedinId'] ?? '',     // linkedinId
            $data['city'],         // city
            $data['state'],        // state
            $data['country'],      // country
            $data['address1'],     // address1
            $data['address2'] ?? '',       // address2
            '',                    // companyName
            ''                     // companyCustomer
        );

        // Enviar mensaje
        $conexion->message("registration", $msg);
        $conexion->send($conexion);

        // Obtener resultado
        $resultado = $conexion->getLastMessageStatus();
        
        // Log del resultado
        $logEntry = [
            'timestamp' => date('c'),
            'result' => $resultado,
            'success' => ($resultado[1] == 0)
        ];
        
        file_put_contents(
            __DIR__."/../../storage/logs/d2a.log", 
            json_encode($logEntry, JSON_PRETTY_PRINT) . "\n---\n", 
            FILE_APPEND
        );

        return $resultado[1] == 0;
    }
}
