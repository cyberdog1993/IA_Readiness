<x-filament-panels::page class="fi-dashboard-page">
    <div class="mb-8 overflow-hidden rounded-[2rem] border border-sky-100 bg-gradient-to-br from-white via-sky-50 to-blue-100 p-8 shadow-2xl shadow-sky-100/60">
        <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
            <div class="space-y-4">
                <div class="inline-flex rounded-full border border-sky-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-sky-700">
                    Consultores IT Automation Platform
                </div>
                <div class="space-y-3">
                    <h1 class="text-4xl font-semibold tracking-tight text-slate-900">
                        Escritorio operativo para diagnóstico, preventa y ejecución.
                    </h1>
                    <p class="max-w-2xl text-base leading-7 text-slate-600">
                        Aquí ves los leads entrantes, la madurez promedio, el avance de procesos y las oportunidades priorizadas para automatización.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ url('/admin/leads') }}" class="rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-500">
                        Revisar leads
                    </a>
                    <a href="{{ url('/admin/clients') }}" class="rounded-full border border-sky-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-sky-50">
                        Ver clientes
                    </a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-white/70 bg-white/85 p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Estado</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-900">Listo para operar</p>
                    <p class="mt-1 text-sm text-slate-600">Panel interno con datos listos para preventa.</p>
                </div>
                <div class="rounded-2xl border border-white/70 bg-white/85 p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Salida</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-900">Markdown, Word, Excel</p>
                    <p class="mt-1 text-sm text-slate-600">Preparado para IA y documentación ejecutiva.</p>
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
