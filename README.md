# Enhanced Logging para Laravel

## 🚀 Descripción

`esalud/enhanced-logging` es un paquete de logging avanzado para Laravel que proporciona:

- 🔒 Redacción automática de campos sensibles
- 📊 Logging contextual con información de IP y trace ID
- 🛡️ Formato de log personalizado
- 🔧 Configuración flexible
- 📝 Soporte para múltiples canales de log

## 📦 Instalación

### Requisitos

- PHP 8.1+
- Laravel 11.x

### Instalación via Composer

```bash
composer require esalud/enhanced-logging
```

### Publicar Configuración

```bash
php artisan vendor:publish --provider="Esalud\EnhancedLogging\Providers\EnhancedLoggingServiceProvider"
```

## 🛠️ Configuración

### Archivo `.env`

```env
# Habilitar modo de depuración
ENHANCED_LOGGING_DEBUG=true
```

### Archivo `config/enhanced-logging.php`

```php
return [
    // Habilitar modo de depuración
    'debug' => env('ENHANCED_LOGGING_DEBUG', false),

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
```

## 🔍 Uso Básico

### Usando el Trait de Logging

```php
use Esalud\EnhancedLogging\Traits\ContextualLogging;

class MiClase 
{
    use ContextualLogging;

    public function metodo()
    {
        // Log de depuración con redacción automática
        $this->debugLog('Mensaje de depuración', [
            'user_id' => $user->id,
            'password' => 'secreto' // Se redactará automáticamente
        ]);

        // Log de error con contexto
        $this->errorLog('Ocurrió un error', [
            'exception' => $exception->getMessage()
        ]);
    }
}
```

### Métodos de Logging Disponibles

- `debugLog()`: Registra mensajes de depuración
- `errorLog()`: Registra mensajes de error
- `contextLog()`: Método genérico para logging personalizado

## 🔒 Características de Seguridad

- Redacción automática de campos sensibles
- Registro de IP y trace ID
- Formato de log que no expone información confidencial

## 📈 Personalización Avanzada

### Campos Sensibles Personalizados

Puedes agregar campos sensibles en `config/enhanced-logging.php`:

```php
'sensitive_fields' => [
    'password', 
    'token', 
    'secret', 
    'api_key',
    'mi_campo_sensible'
]
```

## 🚧 Mejoras Futuras

- [ ] Soporte para logging asíncrono
- [ ] Integración con servicios de monitoreo
- [ ] Más opciones de formateo de logs
- [ ] Soporte para logging distribuido

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor, abre un issue o un pull request.

## 📄 Licencia

MIT License

## 🛡️ Seguridad

Si encuentras una vulnerabilidad de seguridad, por favor envía un email a [tu-email@example.com].

## 📞 Soporte

Para soporte, abre un issue en el repositorio de GitHub o contáctanos por email.
