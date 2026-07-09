@extends('layouts.public')

@section('title', 'Diagnóstico de Madurez para Automatización con IA')
@section('meta_description', 'Diagnóstico comercial y técnico para evaluar madurez de automatización, detectar oportunidades y preparar una propuesta de consultoría.')
@section('og_title', 'Diagnóstico de Madurez para Automatización con IA')
@section('og_description', 'Evalúa la madurez de tu operación, identifica oportunidades y recibe una salida comercial lista para consultoría.')

@section('content')
<div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-start">
    <section class="space-y-8">
        <div class="inline-flex items-center gap-3 rounded-full border border-cyan-400/20 bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-100">
            <img src="{{ asset('images/consultores-it-logo.jpeg') }}" alt="Consultores IT" class="h-8 w-8 rounded-full bg-white/90 object-cover p-0.5">
            Consultores IT Automation Platform
        </div>

        <div class="space-y-5">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-200">Diagnóstico comercial y técnico</p>
            <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-white md:text-6xl">
                Diagnóstico de Madurez para Automatización con IA.
            </h1>
            <p class="max-w-2xl text-lg leading-8 text-slate-300">
                Identificamos cuellos de botella, medimos la madurez de tu operación y te devolvemos una salida comercial lista para consultoría, preventa y ejecución.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">Problema</p>
                <p class="mt-2 text-xl font-semibold text-white">Tiempo perdido en tareas manuales, reportes y coordinación entre sistemas.</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">Solución</p>
                <p class="mt-2 text-xl font-semibold text-white">Un formulario guiado que prioriza procesos, ahorro y automatización realista.</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">Beneficio</p>
                <p class="mt-2 text-xl font-semibold text-white">Obtienes una base para propuesta, backlog, exportación y seguimiento comercial.</p>
            </div>
        </div>

        <div class="rounded-3xl border border-cyan-400/15 bg-cyan-500/10 p-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Ejemplo de resultado</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Diagnóstico, oportunidades y ahorro estimado</h2>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-right">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Salida comercial</p>
                    <p class="text-lg font-semibold text-white">Puntaje + recomendación</p>
                </div>
            </div>
            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                    <p class="text-sm text-slate-400">Madurez</p>
                    <p class="mt-2 text-3xl font-semibold text-white">100 pts</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                    <p class="text-sm text-slate-400">Ahorro</p>
                    <p class="mt-2 text-3xl font-semibold text-white">Horas recuperadas</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                    <p class="text-sm text-slate-400">Acción</p>
                    <p class="mt-2 text-3xl font-semibold text-white">Agendar reunión</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('diagnosis.form') }}" data-track-event="cta_request_diagnosis" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-400 to-blue-500 px-6 py-3 font-bold text-slate-950 shadow-xl shadow-cyan-950/30">
                Solicitar diagnóstico
            </a>
            <a href="https://www.consultores-it.pe" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-6 py-3 font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                Visitar web principal
            </a>
        </div>
    </section>

    <aside class="space-y-5 rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-blue-950/30 backdrop-blur">
        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Qué recibes</p>
            <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-300">
                <li>• Puntaje de madurez sobre 100.</li>
                <li>• Diagnóstico breve y oportunidades de automatización.</li>
                <li>• Recomendación técnica y comercial.</li>
                <li>• Base para propuesta, backlog y exportaciones.</li>
            </ul>
        </div>

        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Contacto</p>
            <div class="mt-4 space-y-3 text-sm">
                <a href="mailto:julio.valdez@consultores.it" class="block rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    julio.valdez@consultores.it
                </a>
                <a href="https://wa.me/51941108521" target="_blank" rel="noreferrer" class="block rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    WhatsApp +51 941 108 521
                </a>
            </div>
        </div>

        <div class="rounded-[1.5rem] border border-cyan-400/15 bg-cyan-500/10 p-5">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Siguiente paso</p>
            <p class="mt-3 text-sm leading-6 text-slate-200">
                Si quieres empezar la consultoría, abre el diagnóstico. El formulario está pensado para avanzar por partes y capturar la información necesaria sin perder foco comercial.
            </p>
            <a href="{{ route('diagnosis.form') }}" data-track-event="cta_request_diagnosis_secondary" class="mt-4 inline-flex w-full items-center justify-center rounded-2xl bg-white px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-100">
                Abrir diagnóstico
            </a>
        </div>
    </aside>
</div>
@endsection
