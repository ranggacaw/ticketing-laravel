<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payment $payment): bool
    {
        return $user->isAdmin() || $user->hasRole(User::ROLE_STAFF) || $payment->user_id === $user->id;
    }
}
