<?php

namespace Esalud\EnhancedLogging\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Illuminate\Support\Facades\Log;

class EnhancedLoggingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/enhanced-logging.php' => config_path('enhanced-logging.php'),
        ], 'config');

        // Configuración de logging
        $config = config('enhanced-logging', [
            'debug' => true,
            'sensitive_fields' => ['password', 'token'],
            'max_log_files' => 5,
            'max_log_file_size' => 5 * 1024 * 1024, // 5MB
        ]);

        // Crear handler de log personalizado
        $handler = new StreamHandler(
            storage_path('logs/laravel.log'), 
            $config['debug'] ? Logger::DEBUG : Logger::INFO
        );

        // Formato de log personalizado
        $formatter = new LineFormatter(
            "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
            'Y-m-d H:i:s',
            true,
            true
        );
        $handler->setFormatter($formatter);

        // Configurar logging directamente
        config(['logging.channels.single.handler' => $handler]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/enhanced-logging.php', 
            'enhanced-logging'
        );
    }
}
