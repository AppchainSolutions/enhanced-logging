<?php

namespace Esalud\EnhancedLogging\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Trait ContextualLogging
 * 
 * Proporciona métodos de logging avanzados con contexto detallado y seguro.
 * 
 * @package Esalud\EnhancedLogging\Traits
 */
trait ContextualLogging
{
    /**
     * Log con contexto detallado y seguro
     * 
     * @param string $level Nivel de log (debug, info, warning, error, critical)
     * @param string $message Mensaje de log
     * @param array $context Contexto adicional
     * @param bool $sanitize Indica si se deben sanitizar datos sensibles
     * @return void
     */
    protected function contextLog(
        string $level, 
        string $message, 
        array $context = [], 
        bool $sanitize = true
    ) {
        // Añadir contexto adicional
        $context['trace_id'] = Str::uuid();
        $context['ip'] = request()->ip();
        
        // Agregar información de clase y método si está habilitado
        if (config('enhanced-logging.context.include_class', false)) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 
                config('enhanced-logging.context.trace_depth', 2));
            
            if (isset($backtrace[1])) {
                $caller = $backtrace[1];
                $context['source'] = strtr(
                    config('enhanced-logging.context.format', '{class}::{method}'), 
                    [
                        '{class}' => $caller['class'] ?? 'Unknown',
                        '{method}' => $caller['function'] ?? 'Unknown'
                    ]
                );
            }
        }
        
        // Sanitizar datos sensibles
        if ($sanitize) {
            $context = $this->sanitizeContext($context);
        }

        // Registrar log con contexto
        Log::log($level, $message, $context);
    }

    /**
     * Sanitizar datos sensibles
     * 
     * @param array $context Contexto a sanitizar
     * @return array Contexto sanitizado
     */
    private function sanitizeContext(array $context): array
    {
        $sensitiveFields = config('enhanced-logging.sensitive_fields', [
            'password', 'token', 'secret', 'api_key', 'credit_card'
        ]);

        foreach ($sensitiveFields as $field) {
            if (isset($context[$field])) {
                $context[$field] = '****REDACTED****';
            }
        }

        return $context;
    }

    /**
     * Log de depuración con contexto
     * 
     * @param string $message Mensaje de log
     * @param array $context Contexto adicional
     */
    protected function debugLog(string $message, array $context = [])
    {
        $this->contextLog('debug', $message, $context);
    }

    /**
     * Log de información con contexto
     * 
     * @param string $message Mensaje de log
     * @param array $context Contexto adicional
     */
    protected function infoLog(string $message, array $context = [])
    {
        $this->contextLog('info', $message, $context);
    }

    /**
     * Log de advertencia con contexto
     * 
     * @param string $message Mensaje de log
     * @param array $context Contexto adicional
     */
    protected function warningLog(string $message, array $context = [])
    {
        $this->contextLog('warning', $message, $context);
    }

    /**
     * Log de error con contexto
     * 
     * @param string $message Mensaje de log
     * @param array $context Contexto adicional
     */
    protected function errorLog(string $message, array $context = [])
    {
        $this->contextLog('error', $message, $context);
    }

    /**
     * Log crítico con contexto
     * 
     * @param string $message Mensaje de log
     * @param array $context Contexto adicional
     */
    protected function criticalLog(string $message, array $context = [])
    {
        $this->contextLog('critical', $message, $context);
    }
}
