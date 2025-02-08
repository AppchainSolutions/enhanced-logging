# Enhanced Logging

## Descripción
Paquete de logging avanzado para Laravel con características de seguridad y contexto mejoradas.

## Características

### Contexto Detallado
- Inclusión automática de información de clase y método
- Generación de UUID único por log
- Captura de dirección IP del request

### Seguridad
- Sanitización de campos sensibles
- Redacción automática de información confidencial
- Configuración flexible de campos sensibles

### Niveles de Log
- Debug
- Info
- Warning
- Error
- Critical

## Instalación

```bash
composer require esalud/enhanced-logging
```

## Configuración

En `config/enhanced-logging.php`:

```php
return [
    'debug' => env('APP_DEBUG', false),
    
    'sensitive_fields' => [
        'password', 
        'token', 
        'secret', 
        'api_key'
    ],

    'context' => [
        'include_class' => true,
        'include_method' => true,
        'trace_depth' => 2,
        'format' => '{class}::{method}'
    ]
];
```

## Uso

```php
use Esalud\EnhancedLogging\Traits\ContextualLogging;

class MiClase 
{
    use ContextualLogging;

    public function miMetodo()
    {
        $this->debugLog('Mensaje de depuración', [
            'parametro1' => 'valor1'
        ]);

        $this->errorLog('Ocurrió un error', [
            'detalles' => 'Información del error'
        ]);
    }
}
```

## Contribuciones
Por favor, lea CONTRIBUTING.md para detalles sobre nuestro código de conducta y proceso de envío de pull requests.

## Licencia
Este proyecto está bajo la Licencia MIT - vea LICENSE.md para más detalles.
