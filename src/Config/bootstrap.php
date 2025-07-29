<?php
/**
 * Bootstrap del microservicio D2A
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Configuración básica
define('ENVIRONMENT', $_ENV['ENVIRONMENT'] ?? 'development');
define('DEBUG', ENVIRONMENT === 'development');

// Configuración de D2A
define('D2A_API_URL', $_ENV['D2A_API_URL'] ?? 'https://api.d2a.com');
define('D2A_API_KEY', $_ENV['D2A_API_KEY'] ?? '');
define('D2A_SECRET_KEY', $_ENV['D2A_SECRET_KEY'] ?? '');

// Configuración de logs
define('LOG_PATH', __DIR__ . '/../../storage/logs');
define('LOG_LEVEL', DEBUG ? 'DEBUG' : 'INFO');

// Función para obtener configuración
function config($key, $default = null) {
    $config = [
        'environment' => ENVIRONMENT,
        'debug' => DEBUG,
        'd2a_api_url' => D2A_API_URL,
        'd2a_api_key' => D2A_API_KEY,
        'd2a_secret_key' => D2A_SECRET_KEY,
        'log_path' => LOG_PATH,
        'log_level' => LOG_LEVEL
    ];
    
    return $config[$key] ?? $default;
}