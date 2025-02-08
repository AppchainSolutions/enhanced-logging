<?php

namespace Esalud\EnhancedLogging\Tests;

use Orchestra\Testbench\TestCase;
use Esalud\EnhancedLogging\Traits\ContextualLogging;
use Illuminate\Support\Facades\Log;

class ContextualLoggingTest extends TestCase
{
    use ContextualLogging;

    public function testContextLog()
    {
        Log::shouldReceive('log')
           ->once()
           ->with(
               'debug', 
               'Test message', 
               \Mockery::on(function($context) {
                   return 
                       isset($context['trace_id']) && 
                       isset($context['ip']) && 
                       $context['password'] === '****REDACTED****';
               })
           );

        $this->debugLog('Test message', [
            'password' => 'secret'
        ]);
    }
}
