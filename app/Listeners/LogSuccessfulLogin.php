<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\ActivityLogger;

class LogSuccessfulLogin
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
    public function handle(Login $event): void
    {
        ActivityLogger::log('LOGIN', $event->user, [], 'User logged in');
    }
}
