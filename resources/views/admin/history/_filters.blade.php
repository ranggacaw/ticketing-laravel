<form action="{{ route('admin.history.index') }}" method="GET" class="glass-card p-6 rounded-3xl border-black/5 dark:border-white/5 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- User Search -->
        <div class="space-y-2">
            <label for="user_id" class="text-xs font-semibold text-slate-400 uppercase tracking-widest">User</label>
            <select name="user_id" id="user_id" class="w-full bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer">
                <option value="">All Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Action Types -->
        <div class="space-y-2">
            <label for="action" class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Action</label>
            <select name="action[]" id="action" multiple class="w-full bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all h-[42px] min-h-[42px]">
                @foreach($actions as $act)
                    <option value="{{ $act }}" {{ in_array($act, (array)request('action')) ? 'selected' : '' }}>{{ $act }}</option>
                @endforeach
            </select>
             <p class="text-[10px] text-slate-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
        </div>

        <!-- Date Range -->
        <div class="space-y-2">
            <label class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Date Range</label>
            <div class="flex items-center gap-2">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all">
                <span class="text-slate-400">-</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all">
            </div>
        </div>

        <!-- Search -->
        <div class="space-y-2">
            <label for="search" class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Search</label>
            <div class="relative">
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search description..." class="w-full bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 pt-4 border-t border-black/5 dark:border-white/5">
        <a href="{{ route('admin.history.index') }}" class="px-6 py-2.5 rounded-xl border border-black/10 dark:border-white/10 text-slate-600 dark:text-slate-300 font-medium hover:bg-black/5 dark:hover:bg-white/5 transition-all">
            Clear Filters
        </a>
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all shadow-lg shadow-indigo-500/30">
            Apply Filters
        </button>
    </div>
</form>
