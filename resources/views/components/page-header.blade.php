@props([
    'title' => '',
    'subtitle' => '',
])

<header {{ $attributes->merge(['class' => 'bg-white px-6 pb-4 border-b border-slate-100 z-40 transition-colors']) }}>
    <div class="flex items-center space-x-4 mb-4 pt-4">
        <div class="flex-1">
            <h1 class="text-lg font-bold leading-tight text-slate-900 ">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-xs text-slate-500 ">{{ $subtitle }}</p>
            @endif
        </div>
        @if(isset($action))
            <div class="flex items-center">
                {{ $action }}
            </div>
        @endif
    </div>
    @if(isset($bottom))
        <div class="flex space-x-2 overflow-x-auto no-scrollbar py-1 md:flex-wrap md:overflow-visible md:space-x-2">
            {{ $bottom }}
        </div>
    @endif
</header>
