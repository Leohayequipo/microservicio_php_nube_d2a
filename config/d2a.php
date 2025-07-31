<?php
/**
 * Configuración de D2A API
 * Basado en la implementación real de D2A
 */

return [
    // Credenciales de D2A - REEMPLAZAR CON TUS VALORES REALES
    'api_key' => '1D9C0741F1073B246FACA8C793756379',
    'api_secret' => '5E475C13F9E69CBFA321F0D9EF322A03',
    'environment' => 'datst.simbel.com.ar',
    'customer_id' => '98765432',
    
    // URLs de la API
    'api_url' => 'https://datst.simbel.com.ar/Dashboard/Loader/api',
    
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