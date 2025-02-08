# Guía Rápida de Enhanced Logging

## 🚀 Instalación Rápida

### Requisitos
- PHP 8.1+
- Laravel 11.x

### Instalación
```bash
composer require esalud/enhanced-logging
```

## 🔍 Uso Básico

### 1. Usar el Trait en tu Clase

```php
use Esalud\EnhancedLogging\Traits\ContextualLogging;

class MiServicio 
{
    use ContextualLogging;

    public function metodo()
    {
        // Log de depuración
        $this->debugLog('Mensaje de depuración', [
            'user_id' => $user->id,
            'password' => 'secreto' // Se redactará automáticamente
        ]);

        // Log de error
        $this->errorLog('Ocurrió un error', [
            'exception' => $exception->getMessage()
        ]);
    }
}
```

## 🛠️ Configuración

### Configurar en `.env`
```env
ENHANCED_LOGGING_DEBUG=true
```

### Configurar en `config/enhanced-logging.php`
```php
return [
    'sensitive_fields' => [
        'password', 
        'token', 
        'secret'
    ],
    'max_log_files' => 5,
    'max_log_file_size' => 5 * 1024 * 1024 // 5MB
];
```

## 🔒 Características de Seguridad

- Redacción automática de campos sensibles
- Registro de contexto detallado
- No expone información confidencial

## 💡 Consejos Rápidos

- Use `debugLog()` para información de desarrollo
- Use `errorLog()` para errores y excepciones
- Incluya siempre contexto en sus logs
- No registre información sensible directamente

## 🚨 Ejemplos de Uso

### Registro de Paciente
```php
public function registrarPaciente(array $datos)
{
    try {
        $this->debugLog('Iniciando registro', [
            'email' => $datos['email']
        ]);

        $paciente = Paciente::create($datos);

        $this->debugLog('Paciente registrado', [
            'paciente_id' => $paciente->id
        ]);
    } catch (\Exception $e) {
        $this->errorLog('Error en registro', [
            'mensaje' => $e->getMessage()
        ]);
    }
}
```

## 🔍 Depuración

- Revise `storage/logs/laravel.log`
- Use `tail -f storage/logs/laravel.log` para seguimiento en tiempo real

## 🤝 Contribuciones

¡Las contribuciones son bienvenidas! Consulte `CONTRIBUTING.md`
