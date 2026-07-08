@extends('layouts.public')

@section('title', 'Resultado del diagnóstico - '.$lead->company_name)
@section('meta_description', 'Resultado comercial y técnico del diagnóstico de automatización para '.$lead->company_name.'.')

@section('content')
@php
    $recommendedProcesses = $lead->recommendedProcesses();
    $estimatedSavings = $lead->estimatedSavingsHours();
@endphp

<div class="space-y-8">
    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-blue-300">Ficha de diagnóstico generada</p>
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
            <p class="text-sm text-slate-400">Procesos recomendados</p>
            <ul class="mt-2 space-y-2 text-slate-100">
                @foreach ($recommendedProcesses as $process)
                    <li>• {{ $process }}</li>
                @endforeach
            </ul>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Ahorro estimado</p>
            <p class="mt-2 text-3xl font-semibold text-white">{{ number_format($estimatedSavings, 1) }} h/semana</p>
            <button type="button" data-open-consultancy-modal class="mt-4 inline-flex rounded-xl bg-emerald-500 px-4 py-2 font-semibold text-white transition hover:bg-emerald-400">
                Agendar reunión
            </button>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-8">
        @auth
            <div class="flex flex-wrap gap-3">
                <a class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" href="{{ route('exports.markdown', $lead) }}">Exportar Markdown</a>
                <a class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" href="{{ route('exports.json', $lead) }}">Exportar JSON</a>
                <a class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" href="{{ route('exports.excel', $lead) }}">Exportar Excel</a>
                <a class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white" href="{{ route('exports.word', $lead) }}">Exportar Word</a>
                <a class="rounded-xl border border-cyan-300/30 bg-cyan-500/10 px-4 py-2 text-sm text-cyan-100" href="https://wa.me/51941108521?text=Hola%2C%20quiero%20agendar%20una%20reuni%C3%B3n%20sobre%20mi%20diagn%C3%B3stico" target="_blank" rel="noreferrer">Agendar reunión</a>
            </div>
        @endauth
    </section>
</div>

<dialog id="consultancyModal" class="w-full max-w-xl rounded-[2rem] border border-white/10 bg-slate-950 p-0 text-white shadow-2xl shadow-slate-950/60">
    <div class="rounded-[2rem] border border-cyan-400/10 bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 p-8">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Solicitud recibida</p>
                <h2 class="mt-2 text-2xl font-semibold">Gracias por tu interés</h2>
            </div>
            <button type="button" data-close-consultancy-modal class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-sm text-slate-200 transition hover:bg-white/10">Cerrar</button>
        </div>

        <p class="mt-5 text-sm leading-7 text-slate-300">
            Hemos registrado tu interés en avanzar con la consultoría. En breve te contactaremos con una propuesta profesional y el siguiente paso recomendado según tu diagnóstico.
        </p>

        <div class="mt-6 grid gap-3 sm:grid-cols-2">
            <a href="https://www.consultores-it.pe" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                Ir a la web principal
            </a>
            <a href="https://wa.me/51941108521" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center rounded-2xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-400">
                Agendar reunión
            </a>
        </div>

        <p class="mt-5 text-xs uppercase tracking-[0.22em] text-slate-400">
            Consultores IT · Atención profesional y seguimiento comercial
        </p>
    </div>
</dialog>

<script>
(function () {
    const modal = document.getElementById('consultancyModal');
    const openButton = document.querySelector('[data-open-consultancy-modal]');
    const closeButton = document.querySelector('[data-close-consultancy-modal]');

    if (!modal || !openButton || !closeButton) {
        return;
    }

    openButton.addEventListener('click', () => {
        if (typeof modal.showModal === 'function') {
            modal.showModal();
        } else {
            modal.setAttribute('open', 'open');
        }
    });

    closeButton.addEventListener('click', () => {
        modal.close();
    });

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.close();
        }
    });
})();
</script>
@endsection
