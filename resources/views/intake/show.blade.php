@extends('layouts.public')

@section('content')
<div class="mx-auto max-w-5xl">
    <div class="rounded-[2rem] border border-emerald-400/20 bg-emerald-500/10 p-8 shadow-2xl shadow-emerald-950/20">
        <p class="text-xs uppercase tracking-[0.25em] text-emerald-200">Levantamiento guardado</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight text-white">
            {{ $process->name }}
        </h1>
        <p class="mt-3 max-w-3xl text-slate-300">
            La ficha de consultoría quedó registrada para {{ $process->client?->business_name }}. Ya puedes revisarla desde el panel interno y usarla para exportar diagnóstico, propuesta, backlog o insumos para agentes.
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ \App\Filament\Resources\ProcessResource::getUrl('edit', ['record' => $process]) }}" class="rounded-2xl bg-gradient-to-r from-cyan-400 to-blue-500 px-5 py-3 font-bold text-slate-950">
                Abrir en panel interno
            </a>
            <a href="{{ route('consulting-intake.create') }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 font-semibold text-white">
                Crear otro levantamiento
            </a>
            <a href="{{ route('landing') }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 font-semibold text-white">
                Volver al inicio
            </a>
        </div>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-4">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Pasos AS-IS</p>
            <p class="mt-2 text-3xl font-semibold text-white">{{ $process->steps->count() }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Sistemas</p>
            <p class="mt-2 text-3xl font-semibold text-white">{{ $process->systems->count() }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Problemas</p>
            <p class="mt-2 text-3xl font-semibold text-white">{{ $process->problems->count() }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Backlog</p>
            <p class="mt-2 text-3xl font-semibold text-white">{{ $process->backlogItems->count() }}</p>
        </div>
    </div>

    <div class="mt-6 rounded-[2rem] border border-white/10 bg-slate-900/80 p-6">
        <h2 class="text-2xl font-semibold text-white">Resumen rápido</h2>
        <dl class="mt-5 grid gap-4 md:grid-cols-2">
            <div>
                <dt class="text-sm text-slate-400">Cliente</dt>
                <dd class="mt-1 font-semibold text-white">{{ $process->client?->business_name }}</dd>
            </div>
            <div>
                <dt class="text-sm text-slate-400">Área</dt>
                <dd class="mt-1 font-semibold text-white">{{ $process->area ?: 'No indicado' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-slate-400">Responsable</dt>
                <dd class="mt-1 font-semibold text-white">{{ $process->owner ?: 'No indicado' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-slate-400">Frecuencia</dt>
                <dd class="mt-1 font-semibold text-white">{{ $process->frequency ?: 'No indicado' }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection
