<?php
/**
 * Script de prueba local para D2A
 * Ejecutar: php test_d2a_local.php
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\D2AService;

echo "🧪 **Prueba Local de Configuración D2A**\n\n";

try {
    // 1. Verificar que el archivo de configuración existe
    $configPath = __DIR__ . '/config/d2a.php';
    echo "1. Verificando archivo de configuración...\n";
    
    if (!file_exists($configPath)) {
        throw new Exception("❌ Archivo de configuración no encontrado: $configPath");
    }
    echo "✅ Archivo de configuración encontrado\n";
    
    // 2. Cargar configuración
    echo "2. Cargando configuración...\n";
    $config = require $configPath;
    
    // 3. Verificar credenciales
    echo "3. Verificando credenciales...\n";
    if (empty($config['api_key'])) {
        throw new Exception("❌ API Key no configurada");
    }
    if (empty($config['api_secret'])) {
        throw new Exception("❌ API Secret no configurada");
    }
    if (empty($config['customer_id'])) {
        throw new Exception("❌ Customer ID no configurado");
    }
    
    echo "✅ API Key: " . substr($config['api_key'], 0, 8) . "...\n";
    echo "✅ API Secret: " . substr($config['api_secret'], 0, 8) . "...\n";
    echo "✅ Customer ID: " . $config['customer_id'] . "\n";
    echo "✅ API URL: " . $config['api_url'] . "\n";
    
    // 4. Crear instancia del servicio
    echo "4. Creando instancia del servicio D2A...\n";
    $d2aService = new D2AService();
    echo "✅ Servicio D2A creado exitosamente\n";
    
    // 5. Probar payload de test
    echo "5. Probando payload de registro real...\n";
    $testPayload = [
        'operation' => 'registration',
        'registrant' => 'test@example.com',
        'sessionName' => 'test_session',
        'visitorName' => 'test_visitor',
        'data' => [
            'track' => '',
            'registrant' => 'test@example.com',
            'typeOfId' => 'DNI',
            'nationalId' => '12345678',
            'name' => 'Juan',
            'lastName' => 'Pérez',
            'gender' => 'M',
            'age' => 30,
            'email' => 'test@example.com',
            'cellphone' => '+5491112345678',
            'facebookId' => '',
            'instagramId' => '',
            'twitterId' => '',
            'linkedinId' => '',
            'city' => 'Buenos Aires',
            'state' => 'CABA',
            'country' => 'Argentina',
            'address1' => 'Av. Corrientes 123',
            'address2' => '',
            'companyName' => '',
            'companyCustomer' => ''
        ]
    ];
    
    echo "📤 Enviando payload de prueba...\n";
    $success = $d2aService->sendEvent($testPayload);
    
    if ($success) {
        echo "✅ Conexión exitosa con D2A API\n";
        echo "🎉 ¡La configuración está funcionando correctamente!\n";
    } else {
        echo "❌ Error al conectar con D2A API\n";
        echo "📋 Revisar logs en: storage/logs/d2a.log\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 Archivo: " . $e->getFile() . "\n";
    echo "📍 Línea: " . $e->getLine() . "\n";
}

echo "\n📋 **Logs disponibles:**\n";
echo "- D2A Logs: storage/logs/d2a.log\n";
echo "- Webhook Logs: storage/logs/webhooks.log\n"; 