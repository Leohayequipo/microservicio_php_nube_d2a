<?php
/**
 * Configuración de D2A API
 * Basado en la implementación real de D2A
 */

return [
    // Credenciales de D2A - REEMPLAZAR CON TUS VALORES REALES
    'api_key' => 'EBF3E0C2B8B540036ED36DA8004A2F56',
    'api_secret' => '5A167F6E4060C256FF6098ADAFF8A275',
    'environment' => 'datst.simbel.com.ar',
    'customer_id' => '91699759',
    
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