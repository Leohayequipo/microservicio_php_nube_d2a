<?php
/**
 * Test simple de conectividad con D2A API
 */

echo "🧪 **Test Simple de Conectividad D2A**\n\n";

// Configuración
$apiKey = 'EBF3E0C2B8B540036ED36DA8004A2F56';
$apiSecret = '5A167F6E4060C256FF6098ADAFF8A275';
$environment = 'datst.simbel.com.ar';
$customer = '91699759';

// URL de la API
$url = "https://{$environment}/Dashboard/Loader/api";

echo "🔗 **URL de la API:** $url\n\n";

// Payload simple de prueba
$testPayload = [
    'track' => [
        'cs' => $customer,
        'abuVer' => 'APIV1.1',
        'ts' => date('YmdHis'),
        'tz' => '-0300',
        'sessionName' => 'test_session',
        'visitorName' => 'test_visitor',
        'registrant' => 'test@example.com',
        'operation' => 'test',
        'ApiKey' => $apiKey,
        'hs' => md5($apiKey . $apiSecret . $customer . 'test@example.com' . 'test'),
        'ip' => '127.0.0.1'
    ],
    'ms' => [
        'test' => true,
        'timestamp' => date('c'),
        'message' => 'Test de conectividad'
    ]
];

echo "📤 **Payload de prueba:**\n";
echo json_encode($testPayload, JSON_PRETTY_PRINT) . "\n\n";

// Configurar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['data' => json_encode($testPayload)]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_USERAGENT, "d2a API Test");
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);

// Capturar verbose output
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

echo "📤 **Enviando request...**\n";

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
$info = curl_getinfo($ch);

echo "📊 **Resultados:**\n";
echo "HTTP Code: $httpCode\n";
echo "cURL Error: " . ($error ?: 'Ninguno') . "\n";
echo "Response: " . ($response ?: 'Vacía') . "\n\n";

// Mostrar información detallada de cURL
echo "🔍 **Información detallada de cURL:**\n";
echo "Total Time: " . $info['total_time'] . "s\n";
echo "Connect Time: " . $info['connect_time'] . "s\n";
echo "Name Lookup Time: " . $info['namelookup_time'] . "s\n";
echo "Redirect Count: " . $info['redirect_count'] . "\n";
echo "Effective URL: " . $info['url'] . "\n\n";

// Mostrar verbose output
rewind($verbose);
$verboseLog = stream_get_contents($verbose);
echo "📝 **Verbose Log:**\n";
echo $verboseLog . "\n";

curl_close($ch);
fclose($verbose);

if ($response) {
    $decoded = json_decode($response, true);
    if ($decoded) {
        echo "✅ **Respuesta JSON válida:**\n";
        echo json_encode($decoded, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "❌ **Respuesta no es JSON válido:**\n";
        echo "Raw response: " . $response . "\n";
    }
} else {
    echo "❌ **No se recibió respuesta**\n";
} 