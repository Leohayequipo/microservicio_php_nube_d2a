<?php
/**
 * Test del microservicio D2AService
 */

require_once __DIR__ . '/src/Services/D2AService.php';

echo "🧪 **Test del Microservicio D2AService**\n\n";

try {
    $d2aService = new App\Services\D2AService();
    
    // Simular datos del checkout de Tienda Nube
    $checkoutData = [
        'registrant' => 'test@example.com',
        'typeOfId' => 'DNI',
        'nationalId' => '12345678',
        'name' => 'Juan',
        'lastName' => 'Pérez',
        'gender' => 'M',
        'age' => 25,
        'email' => 'test@example.com',
        'cellphone' => '+5491112345678',
        'facebookId' => '',
        'instagramId' => '',
        'twitterId' => '',
        'linkedinId' => '',
        'city' => 'Buenos Aires',
        'state' => 'Buenos Aires',
        'country' => 'ARG',
        'address1' => 'Av. Corrientes 123',
        'address2' => '',
        'totalInCart' => 1000,
        'totalBought' => 1000
    ];
    
    // Simular abu_session del frontend
    $abuSession = '["99666444","08/01/2025 09:38:16","-0300","f63ffdd75b5b3d0e50ba462db9a2d761","9951648c01172947203dc670e329fecf","test@example.com"]';
    
    echo "📋 **Datos de entrada:**\n";
    echo "Checkout data: " . json_encode($checkoutData, JSON_PRETTY_PRINT) . "\n";
    echo "ABU Session: $abuSession\n\n";
    
    echo "📤 **Enviando ABU_registration...**\n";
    
    $result = $d2aService->registerCustomer($checkoutData, $abuSession);
    
    echo "📊 **Resultado:**\n";
    echo "Success: " . ($result ? "✅ SÍ" : "❌ NO") . "\n";
    
    if ($result) {
        echo "✅ ¡Éxito! ABU_registration enviado correctamente.\n";
    } else {
        echo "❌ Error al enviar ABU_registration.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
} 