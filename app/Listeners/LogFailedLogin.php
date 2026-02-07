<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Services\ActivityLogger;

class LogFailedLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        $metadata = [
            'email' => $event->credentials['email'] ?? 'unknown',
        ];
        
        ActivityLogger::log('LOGIN_FAILED', null, $metadata, 'Login failed');
    }
}
