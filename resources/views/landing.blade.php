@extends('layouts.public')

@section('content')
<div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
    <section class="space-y-6">
        <div class="inline-flex rounded-full border border-blue-500/30 bg-blue-500/10 px-4 py-2 text-sm text-blue-200">
            Consultores IT Automation Platform
        </div>
        <div class="space-y-4">
            <h1 class="text-4xl font-semibold tracking-tight text-white md:text-6xl">Diagnóstico de automatización para preventa, ejecución y expansión comercial.</h1>
            <p class="max-w-2xl text-lg text-slate-300">
                Captura leads, mide madurez, registra procesos y deja todo listo para exportar a Markdown, JSON, Excel y Word.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <p class="text-sm text-slate-400">Madurez</p>
                <p class="text-2xl font-semibold">100 pts</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <p class="text-sm text-slate-400">Exportación</p>
                <p class="text-2xl font-semibold">Markdown + JSON</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <p class="text-sm text-slate-400">Panel interno</p>
                <p class="text-2xl font-semibold">Filament</p>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-blue-950/40">
        <h2 class="mb-6 text-2xl font-semibold text-white">Pre-formulario público</h2>

        <form method="POST" action="{{ route('leads.store') }}" class="grid gap-4">
            @csrf
            @foreach ([
                ['company_name','Empresa','text'],
                ['ruc','RUC','text'],
                ['industry','Rubro','text'],
                ['contact_name','Nombre del contacto','text'],
                ['contact_role','Cargo','text'],
                ['email','Correo','email'],
                ['phone','Teléfono','text'],
                ['company_size','Tamaño de empresa','text'],
                ['repetitive_process_count','Cantidad de procesos repetitivos','number'],
                ['manual_hours_weekly','Horas semanales en tareas manuales','number'],
                ['process_documentation_level','Nivel de documentación de procesos','number'],
                ['digital_system_usage','Uso de sistemas digitales','number'],
                ['excel_dependency','Uso crítico de Excel','number'],
                ['system_integration_level','Integración entre sistemas','number'],
                ['manual_report_generation','Generación manual de reportes','number'],
                ['key_person_dependency','Dependencia de personas clave','number'],
                ['automation_interest','Interés en automatizar','number'],
            ] as [$name, $label, $type])
                <label class="grid gap-2">
                    <span class="text-sm text-slate-300">{{ $label }}</span>
                    <input name="{{ $name }}" type="{{ $type }}" value="{{ old($name) }}" class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none ring-0 placeholder:text-slate-500 focus:border-blue-400" />
                    @error($name)
                        <span class="text-sm text-red-300">{{ $message }}</span>
                    @enderror
                </label>
            @endforeach

            <label class="grid gap-2">
                <span class="text-sm text-slate-300">Existencia de KPIs</span>
                <select name="has_kpis" class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
                    <option value="1" @selected(old('has_kpis', '1') == '1')>Sí</option>
                    <option value="0" @selected(old('has_kpis') === '0')>No</option>
                </select>
            </label>

            <button class="mt-2 rounded-xl bg-blue-500 px-5 py-3 font-semibold text-white transition hover:bg-blue-400">
                Solicitar consultoría
            </button>
        </form>
    </section>
</div>
@endsection
