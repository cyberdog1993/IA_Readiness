@props([
    'step',
    'title',
    'subtitle' => null,
])

<section data-intake-section class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-blue-950/20 backdrop-blur">
    <div class="mb-6 rounded-3xl border border-white/10 bg-white/5 p-5">
        <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Sección {{ $step }}</p>
        <h2 class="mt-2 text-2xl font-semibold text-white">{{ $title }}</h2>
        @if ($subtitle)
            <p class="mt-2 text-sm leading-6 text-slate-400">{{ $subtitle }}</p>
        @endif
    </div>

    <div class="space-y-5">
        {{ $slot }}
    </div>
</section>
