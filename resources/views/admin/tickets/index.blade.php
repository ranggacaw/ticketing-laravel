@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-in fade-in duration-700">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Ticket <span class="gradient-text">Management</span></h2>
            <p class="text-slate-400 mt-1 font-light text-sm">Create and manage internal tickets with scannable barcodes.</p>
        </div>
        <a href="{{ route('admin.tickets.create') }}" class="group relative inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-indigo-600/20">
            <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <span>Generate New Ticket</span>
        </a>
    </div>

    <div class="glass-card rounded-3xl overflow-hidden border-black/5  shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-black/5  bg-black/5 ">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Ticket ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Guest Info</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">Seat</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Type</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Price</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 ">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-black/5  transition-colors duration-200 group">
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-indigo-400 font-mono text-sm font-semibold tracking-wider">#{{ strtoupper(substr($ticket->uuid, 0, 8)) }}</span>
                                <span class="text-xs text-slate-500 mt-0.5">{{ $ticket->created_at->format('M d, H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-slate-900  font-medium">{{ $ticket->user_name }}</span>
                                <span class="text-xs text-slate-500">{{ $ticket->user_email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-slate-100  text-slate-600  font-bold text-xs border border-black/5 ">
                                {{ $ticket->seat_number }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $typeClasses = match($ticket->type) {
                                    'VVIP' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    'VIP' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                    'Festival' => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                                    'General Admission' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    default => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $typeClasses }}">
                                {{ $ticket->type }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($ticket->scanned_at)
                                <span class="inline-flex items-center gap-1 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Validated
                                </span>
                            @else
                                <span class="text-slate-500 text-xs font-bold uppercase tracking-wider">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-slate-700  font-medium">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <button onclick="previewTicket({{ $ticket->id }})" class="p-2 text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all duration-200 cursor-pointer" title="Quick Preview">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="p-2 text-slate-400 hover:text-sky-400 hover:bg-sky-400/10 rounded-xl transition-all duration-200" title="Full Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.tickets.export', $ticket) }}" class="p-2 text-slate-400 hover:text-emerald-400 hover:bg-emerald-400/10 rounded-xl transition-all duration-200" title="Export PDF">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all duration-200 cursor-pointer" onclick="return confirm('Delete this ticket?')" title="Delete Ticket">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-black/5  rounded-2xl flex items-center justify-center text-slate-500 mb-4 glass">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900 ">No tickets found</h3>
                                <p class="text-slate-500 mt-1">Get started by generating your first event ticket.</p>
                                <a href="{{ route('admin.tickets.create') }}" class="mt-4 text-indigo-400 hover:text-indigo-300 font-medium">Create Ticket &rarr;</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($tickets->hasPages())
    <div class="mt-6 flex justify-center">
        <div class="glass px-4 py-2 rounded-2xl border-white/5">
            {{ $tickets->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Preview Modal -->
<div id="preview-modal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity duration-300"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="glass-card w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="modal-container">
            <div class="p-8 border-b border-black/5  flex items-center justify-between">
                <h3 class="text-xl font-bold tracking-tight text-slate-900 ">Ticket <span class="gradient-text">Live Preview</span></h3>
                <button onclick="closeModal()" class="p-2 rounded-xl text-slate-400 hover:text-slate-900  hover:bg-black/5  transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modal-content" class="max-h-[70vh] overflow-y-auto">
                <!-- Data will be loaded here -->
                <div class="flex flex-col items-center justify-center py-20 gap-4">
                    <div class="w-12 h-12 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin"></div>
                    <p class="text-slate-500 text-sm animate-pulse">Generating preview...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewTicket(id) {
        const modal = document.getElementById('preview-modal');
        const container = document.getElementById('modal-container');
        const content = document.getElementById('modal-content');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);

        fetch(`/admin/tickets/${id}/preview`)
            .then(response => response.json())
            .then(data => {
                content.innerHTML = data.html;
            })
            .catch(error => {
                content.innerHTML = `<div class="p-10 text-center text-rose-500">Error loading preview. Please try again.</div>`;
            });
    }

    function closeModal() {
        const modal = document.getElementById('preview-modal');
        const container = document.getElementById('modal-container');
        
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('modal-content').innerHTML = `
                <div class="flex flex-col items-center justify-center py-20 gap-4">
                    <div class="w-12 h-12 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin"></div>
                    <p class="text-slate-500 text-sm animate-pulse">Generating preview...</p>
                </div>
            `;
        }, 300);
    }

    // Close on escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });
</script>
@endsection
