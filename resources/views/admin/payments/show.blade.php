@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6 animate-in fade-in duration-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.payments.index') }}"
                    class="text-slate-400 hover:text-slate-600 bg-white p-2 rounded-xl shadow-sm border border-slate-100 transition-all">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                </a>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">Review Payment</h2>
                    <p class="text-sm text-slate-500 font-mono">#{{ $payment->invoice_number }}</p>
                </div>
            </div>
            <div>
                @if($payment->status === 'pending')
                    <span
                        class="px-4 py-2 rounded-xl bg-amber-100 text-amber-800 font-bold text-sm border border-amber-200 shadow-sm flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> Pending Review
                    </span>
                @elseif($payment->status === 'confirmed')
                    <span
                        class="px-4 py-2 rounded-xl bg-emerald-100 text-emerald-800 font-bold text-sm border border-emerald-200 shadow-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">check_circle</span> Confirmed
                    </span>
                @else
                    <span
                        class="px-4 py-2 rounded-xl bg-rose-100 text-rose-800 font-bold text-sm border border-rose-200 shadow-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">cancel</span> Cancelled
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left: Details & Actions -->
            <div class="space-y-6">
                <!-- Sender Details -->
                <div class="glass-card p-6 rounded-3xl border-black/5 shadow-sm">
                    <h3
                        class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2">
                        Transaction Details</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 text-sm">Sender Name</span>
                            <span class="font-bold text-slate-900">{{ $payment->sender_account_name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 text-sm">Sender Account</span>
                            <span
                                class="font-mono text-slate-900 bg-slate-100 px-2 py-1 rounded text-xs">{{ $payment->sender_account_number }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 text-sm">Destination Bank</span>
                            <span class="font-bold text-indigo-600">{{ $payment->bank->name ?? 'N/A' }}
                                ({{ $payment->bank->code }})</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                            <span class="text-slate-900 font-bold">Total Amount</span>
                            <span class="font-black text-2xl text-slate-900">Rp
                                {{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- User Info -->
                <div class="glass-card p-6 rounded-3xl border-black/5 shadow-sm">
                    <h3
                        class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2">
                        Customer</h3>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 font-bold text-xl">
                            {{ substr($payment->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">{{ $payment->user->name }}</p>
                            <p class="text-sm text-slate-500">{{ $payment->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Linked Tickets -->
                <div class="glass-card p-6 rounded-3xl border-black/5 shadow-sm">
                    <h3
                        class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2">
                        Purchased Tickets ({{ $payment->tickets->count() }})</h3>
                    <div class="space-y-3">
                        @foreach($payment->tickets as $ticket)
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <div>
                                    <p class="text-xs font-bold text-slate-900">{{ $ticket->type }}</p>
                                    <p class="text-[10px] text-slate-500 font-mono">{{ $ticket->uuid }}</p>
                                </div>
                                <span class="text-xs font-medium text-slate-600">{{ $ticket->event->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Actions -->
                @if($payment->status === 'pending')
                    <div class="glass-card p-6 rounded-3xl border-black/5 shadow-sm bg-white/50">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Actions</h3>
                        <div class="flex gap-3">
                            <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">check</span> Approve Payment
                                </button>
                            </form>
                            <button onclick="document.getElementById('rejectModal').showModal()"
                                class="flex-1 py-3 bg-white border-2 border-rose-100 text-rose-600 hover:bg-rose-50 font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">close</span> Reject
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Proof Preview -->
            <div class="glass-card p-1 rounded-3xl border-black/5 shadow-sm overflow-hidden h-fit">
                <div class="bg-slate-900 p-4 flex justify-between items-center rounded-t-[1.3rem]">
                    <h3 class="text-white font-bold text-sm uppercase tracking-widest">Payment Proof</h3>
                    <a href="{{ \Illuminate\Support\Facades\Storage::url($payment->payment_proof_url) }}" target="_blank"
                        class="text-xs text-indigo-300 hover:text-white flex items-center gap-1">
                        Open Original <span class="material-symbols-outlined text-sm">open_in_new</span>
                    </a>
                </div>
                <div class="bg-slate-100 min-h-[400px] flex items-center justify-center p-4">
                    @if(\Illuminate\Support\Str::endsWith($payment->payment_proof_url, '.pdf'))
                        <iframe src="{{ \Illuminate\Support\Facades\Storage::url($payment->payment_proof_url) }}"
                            class="w-full h-[500px] rounded-xl shadow-sm bg-white"></iframe>
                    @else
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($payment->payment_proof_url) }}" alt="Proof"
                            class="max-w-full max-h-[600px] rounded-xl shadow-lg object-contain">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <dialog id="rejectModal" class="modal backdrop-blur-sm">
        <div class="modal-box bg-white rounded-3xl p-8 shadow-2xl max-w-md">
            <h3 class="font-bold text-xl text-slate-900 mb-4">Reject Payment?</h3>
            <p class="text-slate-500 text-sm mb-6">This will cancel the payment and invalidate all associated tickets. The
                tickets will be returned to inventory.</p>

            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Reason for
                        Rejection</label>
                    <textarea name="rejection_reason" required rows-3
                        placeholder="e.g. Invalid amount, duplicate receipt..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('rejectModal').close()"
                        class="px-5 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-slate-100 transition-colors">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-rose-500 text-white font-bold hover:bg-rose-600 shadow-lg shadow-rose-200 transition-colors">Confirm
                        Rejection</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
@endsection