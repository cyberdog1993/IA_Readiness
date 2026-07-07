@extends('layouts.public')

@section('content')
<div class="space-y-8">
    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-blue-300">Diagnóstico generado</p>
                <h1 class="mt-2 text-4xl font-semibold text-white">{{ $lead->company_name }}</h1>
                <p class="mt-3 max-w-3xl text-slate-300">{{ $lead->diagnosis_brief }}</p>
            </div>
            <div class="rounded-2xl border border-blue-400/20 bg-blue-500/10 px-6 py-5 text-center">
                <p class="text-sm text-blue-200">Puntaje</p>
                <p class="text-5xl font-semibold text-white">{{ $lead->maturity_score }}</p>
                <p class="mt-1 text-blue-200">{{ $lead->maturity_level }}</p>
            </div>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Principales oportunidades</p>
            <p class="mt-2 text-slate-100">{{ $lead->opportunities_summary }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Recomendación</p>
            <p class="mt-2 text-slate-100">{{ $lead->recommendation }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Siguiente paso</p>
            <p class="mt-2 text-slate-100">Registrar el proceso AS-IS y priorizar las oportunidades de automatización.</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Consultoría</p>
            <a href="mailto:ventas@consultores-it.pe?subject=Solicitud%20de%20consultor%C3%ADa%20-%20{{ urlencode($lead->company_name) }}" class="mt-3 inline-flex rounded-xl bg-emerald-500 px-4 py-2 font-semibold text-white">
                Solicitar consultoría
            </a>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-8">
        @auth
            <div class="flex flex-wrap gap-3">
                <a class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" href="{{ route('exports.markdown', $lead) }}">Exportar Markdown</a>
                <a class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" href="{{ route('exports.json', $lead) }}">Exportar JSON</a>
                <a class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" href="{{ route('exports.excel', $lead) }}">Exportar Excel</a>
                <a class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" href="{{ route('exports.word', $lead) }}">Exportar Word</a>
            </div>
        @endauth
    </section>
</div>
@endsection
