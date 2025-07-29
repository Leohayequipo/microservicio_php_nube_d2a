<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Especificación OpenAPI manual
$openapi = [
    'openapi' => '3.0.0',
    'info' => [
        'title' => 'Microservicio D2A API',
        'version' => '1.0.0',
        'description' => 'API para integración con D2A - Checkout y Webhooks de Tiendanube'
    ],
    'servers' => [
        [
            'url' => 'http://localhost:8000',
            'description' => 'Servidor de desarrollo'
        ]
    ],
    'paths' => [
        '/checkout-temp' => [
            'post' => [
                'summary' => 'Procesar checkout temporal',
                'description' => 'Recibe datos de checkout y los envía a D2A',
                'tags' => ['Checkout'],
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'required' => ['checkout_id', 'store_id'],
                                'properties' => [
                                    'checkout_id' => [
                                        'type' => 'string',
                                        'example' => 'abc123'
                                    ],
                                    'store_id' => [
                                        'type' => 'integer',
                                        'example' => 456
                                    ],
                                    'payment' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'gateway' => [
                                                'type' => 'string',
                                                'example' => 'mercadopago'
                                            ],
                                            'installments' => [
                                                'type' => 'integer',
                                                'example' => 6
                                            ]
                                        ]
                                    ],
                                    'cart' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'sku' => [
                                                    'type' => 'string',
                                                    'example' => 'PROD1'
                                                ],
                                                'qty' => [
                                                    'type' => 'integer',
                                                    'example' => 2
                                                ],
                                                'price' => [
                                                    'type' => 'number',
                                                    'example' => 1000
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'Checkout procesado exitosamente',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'status' => [
                                            'type' => 'string',
                                            'example' => 'ok'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    '400' => [
                        'description' => 'Datos inválidos',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'error' => [
                                            'type' => 'string',
                                            'example' => 'Invalid JSON'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        '/webhook' => [
            'post' => [
                'summary' => 'Procesar webhook de Tiendanube',
                'description' => 'Recibe eventos de webhook y los envía a D2A',
                'tags' => ['Webhooks'],
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'required' => ['event', 'id'],
                                'properties' => [
                                    'event' => [
                                        'type' => 'string',
                                        'example' => 'order/created'
                                    ],
                                    'id' => [
                                        'type' => 'integer',
                                        'example' => 999
                                    ],
                                    'store_id' => [
                                        'type' => 'integer',
                                        'example' => 456
                                    ],
                                    'checkout' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'id' => [
                                                'type' => 'string',
                                                'example' => 'abc123'
                                            ]
                                        ]
                                    ],
                                    'payment_details' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'gateway' => [
                                                'type' => 'string',
                                                'example' => 'mercadopago'
                                            ],
                                            'installments' => [
                                                'type' => 'integer',
                                                'example' => 6
                                            ]
                                        ]
                                    ],
                                    'customer' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'email' => [
                                                'type' => 'string',
                                                'example' => 'cliente@test.com'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'Webhook procesado exitosamente',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'status' => [
                                            'type' => 'string',
                                            'example' => 'ok'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    '400' => [
                        'description' => 'Datos inválidos',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'error' => [
                                            'type' => 'string',
                                            'example' => 'Invalid JSON'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'tags' => [
        [
            'name' => 'Checkout',
            'description' => 'Endpoints para procesamiento de checkout'
        ],
        [
            'name' => 'Webhooks',
            'description' => 'Endpoints para procesamiento de webhooks de Tiendanube'
        ]
    ]
];

echo json_encode($openapi, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); 