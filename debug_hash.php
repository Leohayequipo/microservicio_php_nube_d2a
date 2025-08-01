<?php
/**
 * Script para debuggear la generación del hash de D2A
 */

$config = require __DIR__ . '/config/d2a.php';

$apiKey = $config['api_key'];
$apiSecret = $config['api_secret'];
$customer = $config['customer_id'];
$operation = 'registration';
$registrant = 'test@example.com';

echo "🔍 **Debug del Hash de D2A**\n\n";

echo "API Key: $apiKey\n";
echo "API Secret: $apiSecret\n";
echo "Customer ID: $customer\n";
echo "Registrant: $registrant\n";
echo "Operation: $operation\n\n";

$stringToHash = $apiKey . $apiSecret . $customer . $registrant . $operation;
echo "String a hashear (ApiKey + ApiSecret + cs + rg + op): $stringToHash\n";


$hash = md5($stringToHash);
echo "Hash generado: $hash\n\n";

// Verificar si coincide con el hash del log
echo "Hash del log anterior: f6ba66622d6f89e5e43bd07c3fc2a87d\n";
echo "¿Coinciden? " . ($hash === 'f6ba66622d6f89e5e43bd07c3fc2a87d' ? '✅ SÍ' : '❌ NO') . "\n";

// Probar con diferentes combinaciones
echo "\n🧪 **Probando diferentes combinaciones:**\n";

$combinations = [
    'apiKey + apiSecret + customer + registrant + operation' => $apiKey . $apiSecret . $customer . $registrant . $operation,
    'apiKey + apiSecret + customer + operation' => $apiKey . $apiSecret . $customer . $operation,
    'apiKey + customer + apiSecret + registrant + operation' => $apiKey . $customer . $apiSecret . $registrant . $operation,
    'customer + apiKey + apiSecret + registrant + operation' => $customer . $apiKey . $apiSecret . $registrant . $operation,
];

foreach ($combinations as $description => $combination) {
    $testHash = md5($combination);
    echo "$description: $testHash\n";
} 