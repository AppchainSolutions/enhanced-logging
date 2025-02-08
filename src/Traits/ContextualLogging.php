<?php

namespace Esalud\EnhancedLogging\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait ContextualLogging
{
    /**
     * Log con contexto detallado y seguro
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
        
        if ($sanitize) {
            $context = $this->sanitizeContext($context);
        }

        Log::log($level, $message, $context);
    }

    /**
     * Sanitizar datos sensibles
     */
    private function sanitizeContext(array $context): array
    {
        $sensitiveFields = config('enhanced-logging.sensitive_fields', [
            'password', 'token', 'secret'
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
     */
    protected function debugLog(string $message, array $context = [])
    {
        $this->contextLog('debug', $message, $context);
    }

    /**
     * Log de error con contexto
     */
    protected function errorLog(string $message, array $context = [])
    {
        $this->contextLog('error', $message, $context);
    }
}
