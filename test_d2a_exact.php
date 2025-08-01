<?php
/**
 * Script que replica exactamente la implementación de D2A del usuario
 */

// Incluir la clase d2a
require_once __DIR__ . '/D2a2Api.php';

echo "🧪 **Test Exacto de D2A**\n\n";

// Configuración exacta como en tu implementación exitosa
$apiKey = 'EBF3E0C2B8B540036ED36DA8004A2F56';
$apiSecret = '5A167F6E4060C256FF6098ADAFF8A275';
$environment = 'datst.simbel.com.ar';
$customer = '91699759';

// Simular exactamente el abu_session de tu ejemplo
$abu_session_string = '["99666444","08/01/2025 09:38:16","-0300","f63ffdd75b5b3d0e50ba462db9a2d761","9951648c01172947203dc670e329fecf",""]';
$abu_session = json_decode($abu_session_string, true);

// Extraer valores como en tu implementación
$userTime = $abu_session[1];           // "08/01/2025 09:38:16"
$userTimeZone = $abu_session[2];       // "-0300"
$sessionName = str_replace('"','',$abu_session[3]);  // "f63ffdd75b5b3d0e50ba462db9a2d761"
$visitorName = str_replace('"','',$abu_session[4]);  // "9951648c01172947203dc670e329fecf"
$registrantEmail = $invitado['email']; // El registrant viene del email del invitado

// Simular el invitado como en tu implementación
$invitado = array(
    "email" => "test@example.com"
);

$operation = 'registration';

echo "Configuración:\n";
echo "API Key: $apiKey\n";
echo "API Secret: $apiSecret\n";
echo "Environment: $environment\n";
echo "Customer: $customer\n";
echo "ABU Session: " . print_r($abu_session, true) . "\n";
echo "Invitado: " . print_r($invitado, true) . "\n";
echo "Session Name: $sessionName\n";
echo "Visitor Name: $visitorName\n";
echo "Registrant: $registrantEmail\n";
echo "Operation: $operation\n";
echo "User Time: $userTime\n";
echo "User Time Zone: $userTimeZone\n\n";

// Crear instancia de d2a exactamente como en tu implementación (sin pasar operation al constructor)
$conexion = new d2a($apiKey, $apiSecret, $environment, $customer, $sessionName, $visitorName, $registrantEmail, "", "", "", $userTime, $userTimeZone);

echo "🔍 **Debug de la instancia d2a:**\n";
echo "ApiKey: " . $conexion->ApiKey . "\n";
echo "ApiSecret: " . $conexion->ApiSecret . "\n";
echo "rs: " . $conexion->rs . "\n";
echo "cs: " . $conexion->cs . "\n";
echo "sn: " . $conexion->sn . "\n";
echo "vn: " . $conexion->vn . "\n";
echo "rg: " . $conexion->rg . "\n";
echo "op: " . $conexion->op . "\n\n";

// Crear mensaje de registration exactamente como en tu implementación
$msg = new d2aRegistration(
    $registrantEmail,      // registrantId
    'DNI',                 // typeOfId
    '12345678',            // nationalId
    'Juan',                // name
    'Pérez',               // lastName
    'N/A',                 // gender
    '',                    // age
    $registrantEmail,      // email
    '+5491112345678',      // cellphone
    '',                    // facebookId
    '',                    // instagramId
    '',                    // twitterId
    '',                    // linkedinId
    '',                    // city
    '',                    // state
    'Argentina',           // country
    'Av. Corrientes 123',  // address1
    '',                    // address2
    '',                    // companyName
    ''                     // companyCustomer
);

echo "📝 **Mensaje de registration creado:**\n";
echo "Registrant: " . $msg->registrant . "\n";
echo "Name: " . $msg->name . "\n";
echo "Email: " . $msg->email . "\n\n";

// Enviar mensaje (esto genera el hash)
$conexion->message($operation, $msg);

echo "🔐 **Hash generado por d2a:**\n";
echo "String a hashear (st): " . $conexion->st . "\n";
echo "Hash (hs): " . $conexion->hs . "\n\n";

echo "📤 **Enviando mensaje...**\n";
$conexion->send($conexion);

// Obtener resultado
$resultado = $conexion->getLastMessageStatus();
echo "📊 **Resultado:**\n";
echo "Message ID: " . $resultado[0] . "\n";
echo "Return Code: " . $resultado[1] . "\n";
echo "Error Code: " . $resultado[2] . "\n";
echo "Session Name: " . $resultado[3] . "\n";
echo "Visitor Name: " . $resultado[4] . "\n";
echo "Registrant: " . $resultado[5] . "\n\n";

if ($resultado[1] == 0 || $resultado[1] == 'OK') {
    echo "✅ ¡Éxito! Conexión con D2A funcionando correctamente.\n";
} else {
    echo "❌ Error: " . $resultado[2] . "\n";
} 