<?php
/**
 * Test para ver la estructura exacta del payload que se envía a D2A
 */

require_once __DIR__ . '/D2a2Api.php';

echo "🔍 **Test de Estructura del Payload D2A**\n\n";

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

// Crear instancia de d2a
$conexion = new d2a($apiKey, $apiSecret, $environment, $customer, $sessionName, $visitorName, $registrantEmail, "", "", "", $userTime, $userTimeZone);

// Crear mensaje de registration
$msg = new d2aRegistration(
    $registrantEmail,      // registrantId
    'DNI',                 // typeOfId
    '12345678',            // nationalId
    'Juan',                // name
    'Pérez',               // lastName
    'M',                   // gender
    25,                    // age
    $registrantEmail,      // email
    '+5491112345678',      // cellphone
    '',                    // facebookId
    '',                    // instagramId
    '',                    // twitterId
    '',                    // linkedinId
    'Buenos Aires',        // city
    'Buenos Aires',        // state
    'Argentina',           // country
    'Av. Corrientes 123',  // address1
    '',                    // address2
    '',                    // companyName
    ''                     // companyCustomer
);

echo "📝 **Mensaje d2aRegistration creado:**\n";
echo "Registrant: " . $msg->registrant . "\n";
echo "Name: " . $msg->name . "\n";
echo "Email: " . $msg->email . "\n";
echo "Track (antes): " . $msg->track . "\n\n";

// Llamar message (esto asigna el track)
$conexion->message("registration", $msg);

echo "📝 **Después de message():**\n";
echo "Registrant: " . $msg->registrant . "\n";
echo "Track (después): " . (is_object($msg->track) ? "Objeto d2aApiTrk" : $msg->track) . "\n\n";

// Verificar si registrant está disponible
echo "🔍 **Verificación de registrant:**\n";
echo "isset(\$msg->registrant): " . (isset($msg->registrant) ? "✅ SÍ" : "❌ NO") . "\n";
echo "empty(\$msg->registrant): " . (empty($msg->registrant) ? "✅ SÍ" : "❌ NO") . "\n";
echo "registrant value: '" . $msg->registrant . "'\n\n";

// Mostrar la estructura completa del mensaje
echo "📋 **Estructura completa del mensaje:**\n";
$messageStructure = [
    'track' => [
        'cs' => $conexion->cs,
        'abuVer' => 'APIV1.1',
        'ts' => $userTime,
        'tz' => $userTimeZone,
        'sessionName' => $sessionName,
        'visitorName' => $visitorName,
        'registrant' => $registrantEmail,
        'operation' => 'registration',
        'ApiKey' => $apiKey,
        'hs' => $conexion->hs,
        'ip' => ''
    ],
    'ms' => [
        'track' => (is_object($msg->track) ? "Objeto d2aApiTrk" : $msg->track),
        'registrant' => $msg->registrant,
        'typeOfId' => $msg->typeOfId,
        'nationalId' => $msg->nationalId,
        'name' => $msg->name,
        'lastName' => $msg->lastName,
        'gender' => $msg->gender,
        'age' => $msg->age,
        'email' => $msg->email,
        'cellphone' => $msg->cellphone,
        'facebookId' => $msg->facebookId,
        'instagramId' => $msg->instagramId,
        'twitterId' => $msg->twitterId,
        'linkedinId' => $msg->linkedinId,
        'city' => $msg->city,
        'state' => $msg->state,
        'country' => $msg->country,
        'address1' => $msg->address1,
        'address2' => $msg->address2,
        'companyName' => $msg->companyName,
        'companyCustomer' => $msg->companyCustomer
    ]
];

echo json_encode($messageStructure, JSON_PRETTY_PRINT) . "\n\n";

// Simular lo que D2A ve
echo "🔍 **Lo que D2A ve:**\n";
echo "D2A busca: \$msg->registrant\n";
echo "Valor encontrado: '" . $msg->registrant . "'\n";
echo "¿D2A debería encontrarlo?: " . (isset($msg->registrant) && !empty($msg->registrant) ? "✅ SÍ" : "❌ NO") . "\n"; 