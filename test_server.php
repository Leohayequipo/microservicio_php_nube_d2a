<?php
// Script simple para probar el servidor

echo "🧪 Probando conexión al servidor...\n\n";

// Probar checkout
$checkoutData = [
    'checkout_id' => 'test_' . time(),
    'store_id' => 123,
    'payment' => ['gateway' => 'mp'],
    'cart' => [['sku' => 'P1', 'qty' => 1]]
];

echo "1️⃣ Probando endpoint /checkout-temp...\n";

$ch = curl_init('http://localhost:8000/checkout-temp');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($checkoutData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "   ❌ Error de conexión: $error\n";
} else {
    echo "   ✅ Status: $httpCode\n";
    echo "   ✅ Response: $response\n";
}

echo "\n2️⃣ Verificando archivos creados...\n";

$tmpDir = __DIR__ . '/storage/tmp';
$logsDir = __DIR__ . '/storage/logs';

if (is_dir($tmpDir)) {
    $files = scandir($tmpDir);
    $tmpFiles = array_filter($files, function($file) {
        return $file !== '.' && $file !== '..' && $file !== '.gitkeep';
    });
    
    if (count($tmpFiles) > 0) {
        echo "   ✅ Archivos temporales creados: " . count($tmpFiles) . "\n";
        foreach ($tmpFiles as $file) {
            echo "      - $file\n";
        }
    } else {
        echo "   ⚠️  No se encontraron archivos temporales\n";
    }
}

if (is_dir($logsDir)) {
    $files = scandir($logsDir);
    $logFiles = array_filter($files, function($file) {
        return $file !== '.' && $file !== '..' && $file !== '.gitkeep';
    });
    
    if (count($logFiles) > 0) {
        echo "   ✅ Archivos de log creados: " . count($logFiles) . "\n";
        foreach ($logFiles as $file) {
            echo "      - $file\n";
        }
    } else {
        echo "   ⚠️  No se encontraron archivos de log\n";
    }
}

echo "\n🎉 ¡Prueba completada!\n";
echo "📁 Revisa las carpetas storage/logs/ y storage/tmp/ para ver los resultados.\n";