<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Auth::user()->payments()->latest()->paginate(10);
        return view('user.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        if (Auth::user()->cannot('view', $payment)) {
            abort(403);
        }
        return view('user.payments.show', compact('payment'));
    }
}
