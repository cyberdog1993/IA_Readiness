@extends('layouts.public')

@section('content')
@php
    $diagnosisLead = $process->client?->lead;
@endphp

<div class="mx-auto max-w-6xl space-y-8">
    <div class="rounded-[2rem] border border-cyan-400/20 bg-cyan-500/10 p-8 shadow-2xl shadow-cyan-950/20">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Proceso del cliente</p>
        <div class="mt-3 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="text-4xl font-semibold tracking-tight text-white md:text-5xl">
                    {{ $process->name }}
                </h1>
                <p class="mt-3 max-w-3xl text-lg leading-8 text-cyan-50/80">
                    Vista resumida del proceso ya levantado. Aquí puedes revisar el estado, exportar la información y volver al portal.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-3 text-center sm:grid-cols-4 lg:min-w-[420px]">
                <div class="rounded-3xl border border-white/10 bg-slate-950/40 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Cliente</p>
                    <p class="mt-2 text-lg font-semibold text-white">{{ $client->business_name }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-slate-950/40 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Pasos</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $process->steps->count() }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-slate-950/40 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Sistemas</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $process->systems->count() }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-slate-950/40 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Tareas</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $process->backlogItems->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('portal.index') }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 font-semibold text-white">
            Volver al portal
        </a>
        <a href="{{ route('consulting-intake.pdf', $process) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 font-semibold text-white">
            Descargar PDF
        </a>
        <a href="{{ route('consulting-intake.markdown', $process) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 font-semibold text-white">
            Descargar Markdown
        </a>
        <a href="{{ route('consulting-intake.json', $process) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 font-semibold text-white">
            Descargar JSON
        </a>
        <button
            type="button"
            data-copy-prompt
            data-prompt="{{ e('Analiza este proceso, resume la situación actual, identifica oportunidades de automatización, estima ROI, define riesgos y redacta una propuesta preliminar comercial y técnica para '.$client->business_name.' / '.$process->name.'.') }}"
            class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 font-semibold text-white"
        >
            Copiar prompt
        </button>
    </div>

    <div class="rounded-[2rem] border border-cyan-400/15 bg-gradient-to-br from-slate-900 to-slate-950 p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Menú de exportación</p>
                <h2 class="mt-2 text-2xl font-semibold text-white">Descarga la ficha del proceso o envíala a IA</h2>
                <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-400">
                    Desde aquí puedes sacar el proceso en PDF, Markdown, JSON o usar el payload para n8n / agentes IA.
                </p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">
                Formatos: PDF, Markdown, JSON y Payload IA / n8n.
            </div>
        </div>

        <div class="mt-5 flex flex-wrap gap-3">
            <a href="{{ route('consulting-intake.pdf', $process) }}" class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-100">
                PDF
            </a>
            <a href="{{ route('consulting-intake.markdown', $process) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                Markdown
            </a>
            <a href="{{ route('consulting-intake.json', $process) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                JSON
            </a>
            @if ($diagnosisLead)
                <a href="{{ route('diagnosis.show', $diagnosisLead) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    Ver diagnóstico comercial
                </a>
            @endif
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <p class="text-sm text-slate-400">Área</p>
            <p class="mt-2 text-xl font-semibold text-white">{{ $process->area ?: 'No indicado' }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <p class="text-sm text-slate-400">Responsable</p>
            <p class="mt-2 text-xl font-semibold text-white">{{ $process->owner ?: 'No indicado' }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <p class="text-sm text-slate-400">Frecuencia</p>
            <p class="mt-2 text-xl font-semibold text-white">{{ $process->frequency ?: 'No indicado' }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <p class="text-sm text-slate-400">Estado</p>
            <p class="mt-2 text-xl font-semibold text-white">{{ $process->status }}</p>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <h2 class="text-2xl font-semibold text-white">Objetivo y resultado esperado</h2>
            <p class="mt-3 text-sm leading-7 text-slate-300">{{ $process->objective ?: 'Sin objetivo definido.' }}</p>
            <p class="mt-3 text-sm leading-7 text-slate-300">{{ $process->expected_result ?: 'Sin resultado esperado definido.' }}</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <h2 class="text-2xl font-semibold text-white">Resumen de diagnóstico</h2>
            @if ($diagnosisLead)
                <p class="mt-3 text-sm leading-7 text-slate-300">
                    {{ $diagnosisLead->diagnosis_brief }}
                </p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('diagnosis.show', $diagnosisLead) }}" class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950">
                        Ver diagnóstico comercial
                    </a>
                </div>
            @else
                <p class="mt-3 text-sm leading-7 text-slate-300">Este proceso aún no tiene un lead asociado.</p>
            @endif
        </div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
        <h2 class="text-2xl font-semibold text-white">Procesos e insumos</h2>
        <div class="mt-4 grid gap-6 lg:grid-cols-2">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Sistemas</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-200">
                    @forelse ($process->systems as $system)
                        <li>• {{ $system->name }} ({{ $system->system_type }})</li>
                    @empty
                        <li>• Sin sistemas registrados</li>
                    @endforelse
                </ul>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Documentos</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-200">
                    @forelse ($process->documents as $document)
                        <li>• {{ $document->name }} ({{ $document->type }})</li>
                    @empty
                        <li>• Sin documentos registrados</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-copy-prompt]').forEach((button) => {
            button.addEventListener('click', async () => {
                const text = button.getAttribute('data-prompt') || '';
                try {
                    await navigator.clipboard.writeText(text);
                    const original = button.textContent;
                    button.textContent = 'Prompt copiado';
                    setTimeout(() => {
                        button.textContent = original;
                    }, 1800);
                } catch (error) {
                    console.error(error);
                }
            });
        });
    </script>
</div>
@endsection
