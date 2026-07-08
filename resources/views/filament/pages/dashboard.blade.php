@php
    $prospectsUrl = \App\Filament\Resources\LeadResource::getUrl();
    $clientsUrl = \App\Filament\Resources\ClientResource::getUrl();
@endphp

<x-filament-panels::page class="fi-dashboard-page">
    <div class="mb-8 overflow-hidden rounded-[2rem] border border-sky-400/15 bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 p-8 shadow-2xl shadow-slate-950/40">
        <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-3 rounded-full border border-sky-300/20 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-sky-100">
                    <img src="{{ asset('images/consultores-it-logo.jpeg') }}" alt="Consultores IT" class="h-8 w-8 rounded-full bg-white/90 object-cover p-0.5">
                    <span>Consultores IT Automation Platform</span>
                </div>
                <div class="space-y-3">
                    <h1 class="text-4xl font-semibold tracking-tight text-white">
                        Escritorio operativo para diagnóstico, preventa y ejecución.
                    </h1>
                    <p class="max-w-2xl text-base leading-7 text-slate-300">
                        Aquí ves los prospectos entrantes, la madurez promedio, el avance de procesos y las oportunidades priorizadas para automatización.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ $prospectsUrl }}" class="rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-500">
                        Revisar prospectos
                    </a>
                    <a href="{{ $clientsUrl }}" class="rounded-full border border-sky-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-sky-50">
                        Ver clientes
                    </a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 shadow-sm backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Estado</p>
                    <p class="mt-2 text-2xl font-semibold text-white">Listo para operar</p>
                    <p class="mt-1 text-sm text-slate-300">Panel interno con datos listos para preventa.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 shadow-sm backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Salida</p>
                    <p class="mt-2 text-2xl font-semibold text-white">Markdown, Word, Excel</p>
                    <p class="mt-1 text-sm text-slate-300">Preparado para IA y documentación ejecutiva.</p>
                </div>
            </div>
        </div>
    </div>

    @if (method_exists($this, 'filtersForm'))
        <div class="mb-6">
            {{ $this->filtersForm }}
        </div>
    @endif

    <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="
            [
                ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                ...$this->getWidgetData(),
            ]
        "
        :widgets="$this->getVisibleWidgets()"
    />
</x-filament-panels::page>
