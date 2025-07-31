<?php
/**
 * Configuración de D2A API
 * Basado en la implementación real de D2A
 */

return [
    // Credenciales de D2A - REEMPLAZAR CON TUS VALORES REALES
    'api_key' => env('D2A_API_KEY', '1D9C0741F1073B246FACA8C793756379'),
    'api_secret' => env('D2A_API_SECRET', '5E475C13F9E69CBFA321F0D9EF322A03'),
    'environment' => env('D2A_ENVIRONMENT', 'datst.simbel.com.ar'),
    'customer_id' => env('D2A_CUSTOMER_ID', '98765432'),
    
    // URLs de la API
    'api_url' => 'https://' . env('D2A_ENVIRONMENT', 'datst.simbel.com.ar') . '/Dashboard/Loader/api',
    
    // Configuración por defecto
    'defaults' => [
        'type_of_id' => 'DNI',
        'country' => 'Argentina',
        'gender' => 'N/A',
        'age' => '',
        'currency' => 'ARS'
    ],
    
    // Configuración de logging
    'logging' => [
        'enabled' => true,
        'file' => __DIR__ . '/../storage/logs/d2a.log',
        'level' => 'debug' // debug, info, warning, error
    ]
]; 