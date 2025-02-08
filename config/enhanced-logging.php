<?php

return [
    // Habilitar modo de depuración
    'debug' => env('APP_DEBUG', false),

    // Campos sensibles a redactar
    'sensitive_fields' => [
        'password', 
        'token', 
        'secret', 
        'api_key'
    ],

    // Máximo número de archivos de log
    'max_log_files' => 5,

    // Tamaño máximo de archivo de log (en bytes)
    'max_log_file_size' => 5 * 1024 * 1024, // 5MB

    // Canales de log adicionales
    'channels' => [
        'security' => [
            'driver' => 'single',
            'path' => storage_path('logs/security.log'),
        ],
        'activation' => [
            'driver' => 'single', 
            'path' => storage_path('logs/activation.log'),
        ]
    ]
];
