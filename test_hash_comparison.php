<?php
/**
 * Test para comparar hashes y encontrar la diferencia
 */

require_once __DIR__ . '/D2a2Api.php';

echo "🔍 **Comparación de Hashes D2A**\n\n";

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

// Test 1: Hash de la clase d2a
echo "🔍 **Test 1: Hash de la clase d2a**\n";
$conexion = new d2a($apiKey, $apiSecret, $environment, $customer, $sessionName, $visitorName, $registrantEmail, "", "", "", $userTime, $userTimeZone);

$msg = new d2aRegistration($registrantEmail, 'DNI', '12345678', 'Juan', 'Pérez', 'M', 25, $registrantEmail, '+5491112345678', '', '', '', '', 'Buenos Aires', 'Buenos Aires', 'Argentina', 'Av. Corrientes 123', '', '', '');

$conexion->message("registration", $msg);

echo "String hasheado (st): " . $conexion->st . "\n";
echo "Hash generado (hs): " . $conexion->hs . "\n\n";

// Test 2: Hash manual según test simple
echo "🔍 **Test 2: Hash manual (test simple)**\n";
$manualString = $apiKey . $apiSecret . $customer . $registrantEmail . 'registration';
$manualHash = md5($manualString);

echo "String manual: $manualString\n";
echo "Hash manual: $manualHash\n\n";

// Test 3: Hash según fórmula de la clase d2a
echo "🔍 **Test 3: Hash según fórmula de la clase d2a**\n";
$d2aString = $conexion->ApiKey . $conexion->ApiSecret . $conexion->cs . $conexion->rg . $conexion->op;
$d2aHash = md5($d2aString);

echo "String d2a: $d2aString\n";
echo "Hash d2a: $d2aHash\n\n";

// Comparaciones
echo "🔍 **Comparaciones:**\n";
echo "Hash clase d2a vs Hash manual: " . ($conexion->hs === $manualHash ? "✅ IGUALES" : "❌ DIFERENTES") . "\n";
echo "Hash clase d2a vs Hash d2a: " . ($conexion->hs === $d2aHash ? "✅ IGUALES" : "❌ DIFERENTES") . "\n";
echo "Hash manual vs Hash d2a: " . ($manualHash === $d2aHash ? "✅ IGUALES" : "❌ DIFERENTES") . "\n\n";

// Valores de la instancia
echo "🔍 **Valores de la instancia d2a:**\n";
echo "ApiKey: " . $conexion->ApiKey . "\n";
echo "ApiSecret: " . $conexion->ApiSecret . "\n";
echo "cs: " . $conexion->cs . "\n";
echo "rg: " . $conexion->rg . "\n";
echo "op: " . $conexion->op . "\n\n";

// Test 4: Hash que funcionó en test simple
echo "🔍 **Test 4: Hash que funcionó en test simple**\n";
$workingString = $apiKey . $apiSecret . $customer . $registrantEmail . 'test';
$workingHash = md5($workingString);

echo "String que funcionó: $workingString\n";
echo "Hash que funcionó: $workingHash\n\n";

echo "🔍 **Conclusión:**\n";
if ($conexion->hs === $manualHash) {
    echo "✅ Los hashes coinciden. El problema no es el hash.\n";
} else {
    echo "❌ Los hashes NO coinciden. El problema ES el hash.\n";
    echo "   - Hash que funciona: $workingHash\n";
    echo "   - Hash que falla: " . $conexion->hs . "\n";
} 