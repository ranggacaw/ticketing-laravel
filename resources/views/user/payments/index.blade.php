@extends('user.layouts.app')

@section('header', 'Payment History')
@section('subheader', 'Track your transactions')

@section('content')
    <div class="bg-slate-800/50 backdrop-blur border border-white/5 rounded-2xl overflow-hidden">
        @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-900/50 border-b border-white/5 text-slate-400 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4">Invoice</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-white">{{ $payment->invoice_number }}</td>
                                <td class="px-6 py-4 text-sm text-slate-300">{{ $payment->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-white">Rp
                                    {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($payment->status === 'confirmed')
                                        <span class="px-2 py-1 bg-green-500/20 text-green-400 text-xs rounded-full">Confirmed</span>
                                    @elseif($payment->status === 'pending')
                                        <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 text-xs rounded-full">Pending</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-500/20 text-red-400 text-xs rounded-full">Cancelled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('user.payments.show', $payment) }}"
                                        class="text-sm text-indigo-400 hover:text-white transition-colors">Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-white/5">
                {{ $payments->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800 mb-4">
                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">No payments found</h3>
                <p class="text-slate-400">Your payment history will appear here.</p>
            </div>
        @endif
    </div>
@endsection