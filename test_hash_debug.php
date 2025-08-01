<?php
/**
 * Debug simple del hash D2A
 */

require_once __DIR__ . '/D2a2Api.php';

echo "🔍 **Debug del Hash D2A**\n\n";

// Configuración
$apiKey = 'EBF3E0C2B8B540036ED36DA8004A2F56';
$apiSecret = '5A167F6E4060C256FF6098ADAFF8A275';
$environment = 'datst.simbel.com.ar';
$customer = '91699759';
$sessionName = 'test_session';
$visitorName = 'test_visitor';
$registrantEmail = 'test@example.com';
$userTime = '08/01/2025 09:38:16';
$userTimeZone = '-0300';

echo "📋 **Configuración:**\n";
echo "ApiKey: $apiKey\n";
echo "ApiSecret: $apiSecret\n";
echo "Customer: $customer\n";
echo "Registrant: $registrantEmail\n";
echo "Operation: registration\n\n";

// Crear instancia
$conexion = new d2a($apiKey, $apiSecret, $environment, $customer, $sessionName, $visitorName, $registrantEmail, "", "", "", $userTime, $userTimeZone);

echo "🔍 **Valores de la instancia:**\n";
echo "ApiKey: " . $conexion->ApiKey . "\n";
echo "ApiSecret: " . $conexion->ApiSecret . "\n";
echo "cs: " . $conexion->cs . "\n";
echo "rg: " . $conexion->rg . "\n";
echo "op: " . $conexion->op . " (antes de message)\n\n";

// Crear mensaje
$msg = new d2aRegistration($registrantEmail, 'DNI', '12345678', 'Juan', 'Pérez', 'N/A', '', $registrantEmail, '+5491112345678', '', '', '', '', 'Buenos Aires', 'Buenos Aires', 'Argentina', 'Av. Corrientes 123', '', '', '');

// Llamar message
$conexion->message("registration", $msg);

echo "🔍 **Después de message():**\n";
echo "op: " . $conexion->op . "\n";
echo "st: " . $conexion->st . "\n";
echo "hs: " . $conexion->hs . "\n\n";

// Verificar hash manual
$manualString = $conexion->ApiKey . $conexion->ApiSecret . $conexion->cs . $conexion->rg . $conexion->op;
$manualHash = md5($manualString);

echo "🔍 **Verificación manual:**\n";
echo "String: $manualString\n";
echo "Hash: $manualHash\n";
echo "Coincide: " . ($conexion->hs === $manualHash ? "✅ SÍ" : "❌ NO") . "\n\n";

// Comparar con test simple
$testSimpleString = $apiKey . $apiSecret . $customer . $registrantEmail . 'test';
$testSimpleHash = md5($testSimpleString);

echo "🔍 **Comparación con test simple:**\n";
echo "Test simple string: $testSimpleString\n";
echo "Test simple hash: $testSimpleHash\n";
echo "Hash de la clase: $conexion->hs\n";
echo "¿Son iguales?: " . ($conexion->hs === $testSimpleHash ? "✅ SÍ" : "❌ NO") . "\n"; 