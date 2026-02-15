@extends('layouts.admin')

@section('content')
<div class="space-y-6 animate-in fade-in duration-700">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold tracking-tight">Payment Verification</h2>
    </div>

    <div class="glass-card rounded-3xl overflow-hidden border-black/5 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-black/5 bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Invoice</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">User</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Amount</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Bank</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                            <td class="px-6 py-4 text-xs font-mono text-slate-500">
                                {{ $payment->invoice_number }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900">{{ $payment->user->name }}</span>
                                    <span class="text-xs text-slate-500">{{ $payment->user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $payment->bank->code ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($payment->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                        Pending
                                    </span>
                                @elseif($payment->status === 'confirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                        Confirmed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $payment->created_at->format('M d, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">payments</span>
                                <p>No payment records found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="p-4 border-t border-black/5 flex justify-center">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
