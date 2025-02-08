<?php

namespace Esalud\EnhancedLogging\Tests\Unit;

use Illuminate\Support\Facades\Log;
use Orchestra\Testbench\TestCase;
use Esalud\EnhancedLogging\Traits\ContextualLogging;

class ContextualLoggingTest extends TestCase
{
    use ContextualLogging;

    /** @test */
    public function it_can_log_debug_messages()
    {
        Log::shouldReceive('debug')
            ->once()
            ->with(
                'Test debug message', 
                \Mockery::subset([
                    'context' => 'test',
                    'user_id' => 1
                ])
            );

        $this->debugLog('Test debug message', [
            'context' => 'test',
            'user_id' => 1
        ]);
    }

    /** @test */
    public function it_redacts_sensitive_fields()
    {
        Log::shouldReceive('debug')
            ->once()
            ->with(
                'Test sensitive logging', 
                \Mockery::subset([
                    'password' => '[REDACTED]',
                    'token' => '[REDACTED]'
                ])
            );

        $this->debugLog('Test sensitive logging', [
            'password' => 'secret123',
            'token' => 'abc123token'
        ]);
    }

    /** @test */
    public function it_can_log_error_messages()
    {
        Log::shouldReceive('error')
            ->once()
            ->with(
                'Test error message', 
                \Mockery::subset([
                    'exception' => 'Test exception'
                ])
            );

        $this->errorLog('Test error message', [
            'exception' => 'Test exception'
        ]);
    }

    /** @test */
    public function it_handles_empty_context()
    {
        Log::shouldReceive('debug')
            ->once()
            ->with('Empty context message', []);

        $this->debugLog('Empty context message');
    }
}
