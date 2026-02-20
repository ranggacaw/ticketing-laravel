@extends('user.layouts.app')

@section('content')
    <div class="min-h-screen -mx-4 md:mx-0 font-display px-6 md:px-0">
        <!-- Header -->
        <x-page-header title="Payment History" subtitle="Track your transactions">
        </x-page-header>

        <main class="py-4 md:py-8 md:px-0">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
                @if($payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Invoice</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($payments as $payment)
                                    <tr class="hover:bg-slate-50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <span class="font-mono text-sm font-bold text-slate-900 group-hover:text-primary-ref transition-colors">
                                                {{ $payment->invoice_number }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-slate-500">
                                            {{ $payment->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-black text-slate-900">
                                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($payment->status === 'confirmed' || $payment->status === 'paid')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                    PAID
                                                </span>
                                            @elseif($payment->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                                    PENDING
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                                    {{ strtoupper($payment->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('user.payments.show', $payment) }}"
                                                class="inline-flex items-center gap-1 text-sm font-bold text-primary-ref hover:text-red-700 transition-colors">
                                                Details
                                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $payments->links() }}
                    </div>
                @else
                    <div class="text-center py-24 px-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 mb-6 group">
                            <span class="material-symbols-outlined text-4xl text-slate-300 group-hover:scale-110 transition-transform">receipt_long</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">No payments found</h3>
                        <p class="text-slate-500 max-w-xs mx-auto">Your payment history will appear here once you make a transaction.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection