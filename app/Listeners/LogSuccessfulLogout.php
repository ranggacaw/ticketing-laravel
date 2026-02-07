<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Services\ActivityLogger;

class LogSuccessfulLogout
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
    public function handle(Logout $event): void
    {
        if ($event->user) {
            ActivityLogger::log('LOGOUT', $event->user, [], 'User logged out');
        }
    }
}
