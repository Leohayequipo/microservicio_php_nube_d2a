<?php
/**
 * Script que simula exactamente la generación del abu_session como en tu implementación
 */

// Incluir la clase d2a
require_once __DIR__ . '/D2a2Api.php';

echo "🧪 **Test ABU Session - Replicando tu implementación exacta**\n\n";

// Configuración exacta como en tu implementación exitosa
$apiKey = 'EBF3E0C2B8B540036ED36DA8004A2F56';
$apiSecret = '5A167F6E4060C256FF6098ADAFF8A275';
$environment = 'datst.simbel.com.ar';
$customer = '91699759';

// Simular $info_registrant como en tu implementación
$info_registrant = [
    0 => '99666444',  // custom
    1 => '08/01/2025 09:38:16',  // userTime
    2 => '-0300',  // userTimeZone
    3 => 'f63ffdd75b5b3d0e50ba462db9a2d761',  // sessionName
    4 => '9951648c01172947203dc670e329fecf',  // visitorName
    5 => 'test@example.com'  // registrant
];

// Simular exactamente el abu_session que se genera en tu JavaScript
$abu_session = [
    $info_registrant[0],  // custom
    $info_registrant[1],  // userTime
    $info_registrant[2],  // userTimeZone
    str_replace('"', '', $info_registrant[3]),  // sessionName
    str_replace('"', '', $info_registrant[4]),  // visitorName
    str_replace(']', '', str_replace('"', '', $info_registrant[5]))  // registrant
];

// Convertir a JSON como en tu implementación
$abu_session_json = json_encode($abu_session);

echo "📋 **Simulación de tu implementación:**\n";
echo "info_registrant: " . print_r($info_registrant, true) . "\n";
echo "abu_session (array): " . print_r($abu_session, true) . "\n";
echo "abu_session (JSON): $abu_session_json\n\n";

// Extraer valores como en tu implementación D2A
$userTime = $abu_session[1];
$userTimeZone = $abu_session[2];
$sessionName = $abu_session[3];
$visitorName = $abu_session[4];
$registrantEmail = $abu_session[5];

// Simular el invitado con datos inventados como en tu implementación
$invitado = array(
    "email" => $registrantEmail,
    "numeroDocumento" => "12345678",
    "nombre" => "Juan",
    "apellido" => "Pérez",
    "telefono" => "+5491112345678",
    "domicilio" => "Av. Corrientes",
    "altura" => "123"
);

echo "🔍 **Valores extraídos:**\n";
echo "User Time: $userTime\n";
echo "User Time Zone: $userTimeZone\n";
echo "Session Name: $sessionName\n";
echo "Visitor Name: $visitorName\n";
echo "Registrant: $registrantEmail\n\n";

echo "👤 **Datos del invitado (inventados):**\n";
echo "Email: " . $invitado['email'] . "\n";
echo "DNI: " . $invitado['numeroDocumento'] . "\n";
echo "Nombre: " . $invitado['nombre'] . "\n";
echo "Apellido: " . $invitado['apellido'] . "\n";
echo "Teléfono: " . $invitado['telefono'] . "\n";
echo "Dirección: " . $invitado['domicilio'] . " " . $invitado['altura'] . "\n\n";

// Crear instancia de d2a exactamente como en tu implementación
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
$registrantDni = $invitado['numeroDocumento'];
$registrantNombre = $invitado['nombre'];
$registrantApellido = $invitado['apellido'];
$registrantTel = $invitado['telefono'];
$registrantDireccion = $invitado['domicilio'] . " " . $invitado['altura'];
$registrantLocalidad = 'Ciudad Autónoma de Buenos Aires';
$registrantProvincia = 'Buenos Aires';

$msg = new d2aRegistration(
    $registrantEmail,      // registrantId
    'DNI',                 // typeOfId
    $registrantDni,        // nationalId
    $registrantNombre,     // name
    $registrantApellido,   // lastName
    'N/A',                 // gender
    '',                    // age
    $registrantEmail,      // email
    $registrantTel,        // cellphone
    '',                    // facebookId
    '',                    // instagramId
    '',                    // twitterId
    '',                    // linkedinId
    $registrantLocalidad,  // city
    $registrantProvincia,  // state
    'Argentina',           // country
    $registrantDireccion,  // address1
    '',                    // address2
    '',                    // companyName
    ''                     // companyCustomer
);

echo "📝 **Mensaje de registration creado:**\n";
echo "Registrant: " . $msg->registrant . "\n";
echo "Name: " . $msg->name . "\n";
echo "Email: " . $msg->email . "\n";
echo "DNI: " . $msg->nationalId . "\n";
echo "Teléfono: " . $msg->cellphone . "\n";
echo "Dirección: " . $msg->address1 . "\n\n";

// Enviar mensaje (esto genera el hash)
$conexion->message("registration", $msg);

echo "🔐 **Hash generado por d2a:**\n";
echo "String a hashear (st): " . $conexion->st . "\n";
echo "Hash (hs): " . $conexion->hs . "\n\n";

// Debug adicional para verificar los valores
echo "🔍 **Valores usados en el hash:**\n";
echo "ApiKey: " . $conexion->ApiKey . "\n";
echo "ApiSecret: " . $conexion->ApiSecret . "\n";
echo "cs: " . $conexion->cs . "\n";
echo "rg: " . $conexion->rg . "\n";
echo "op: " . $conexion->op . "\n\n";

// Verificar hash manual
$manualHash = md5($conexion->ApiKey . $conexion->ApiSecret . $conexion->cs . $conexion->rg . $conexion->op);
echo "🔍 **Hash manual:**\n";
echo "String: " . $conexion->ApiKey . $conexion->ApiSecret . $conexion->cs . $conexion->rg . $conexion->op . "\n";
echo "Hash: " . $manualHash . "\n\n";

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