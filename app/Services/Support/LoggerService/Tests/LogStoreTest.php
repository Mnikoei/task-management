<?php

namespace App\Services\Support\LoggerService\Tests;

use App\Services\Support\LoggerService\Contracts\HasSensitiveLog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Queue\SerializesModels;
use Tests\TestCase;

class LogStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testSavesLog()
    {
        $event = $this->getTestEventWithContract();
        event(new $event);

        $this->assertDatabaseHas('user_logs', [
            'data' => json_encode(['key' => 'value'])
        ]);
    }

    public function testDoesntSaveEventsThatDoesNotImplementContract()
    {
        $event = $this->getTestEventWithoutContract();
        event(new $event);

        $this->assertDatabaseEmpty('user_logs');
    }

    public function getTestEventWithContract()
    {
        return new class implements HasSensitiveLog
        {
            use Dispatchable, InteractsWithSockets, SerializesModels;

            public function getLogs(): array
            {
                return ['key' => 'value'];
            }
        };
    }

    public function getTestEventWithoutContract()
    {
        return new class
        {
            use Dispatchable, InteractsWithSockets, SerializesModels;

            public function getLogs(): array
            {
                return ['key' => 'value'];
            }
        };
    }
}
