@extends('layouts.public')

@section('title', 'Resultado del diagnóstico - '.$lead->company_name)
@section('meta_description', 'Resultado comercial y técnico del diagnóstico de automatización para '.$lead->company_name.'.')
@section('og_title', 'Resultado del diagnóstico - '.$lead->company_name)
@section('og_description', 'Resumen comercial, ROI estimado y próximo paso recomendado para '.$lead->company_name.'.')

@section('content')
@php
    $recommendedProcesses = $lead->recommendedProcesses();
    $automationCandidates = $lead->automationCandidates();
    $strengths = $lead->strengthsSummary();
    $risks = $lead->risksSummary();
    $currentHours = $lead->annualCurrentHours();
    $potentialHours = $lead->annualPotentialHours();
    $savingsHours = $lead->annualSavingsHours();
    $contactComplete = $lead->contactDetailsComplete();
    $reportDate = $lead->reportDateLabel();
@endphp

@if (session('status') === 'datos-completados')
    <div class="mb-6 rounded-3xl border border-emerald-400/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-100">
        Datos completados. Ya puedes descargar el informe completo y continuar con la propuesta preliminar.
    </div>
@elseif (session('status') === 'propuesta-generada')
    <div class="mb-6 rounded-3xl border border-cyan-400/20 bg-cyan-500/10 px-5 py-4 text-sm text-cyan-100">
        La propuesta preliminar se volvió a preparar con la información disponible.
    </div>
@endif

<div class="space-y-8">
    <section class="overflow-hidden rounded-[2rem] border border-cyan-400/15 bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 p-8 shadow-2xl shadow-slate-950/30">
        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-start">
            <div class="space-y-5">
                <div class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-cyan-100">
                    Evaluación de Madurez para Automatización Inteligente
                </div>
                <div class="space-y-3">
                    <p class="text-sm uppercase tracking-[0.25em] text-cyan-200">AI Automation Assessment by Consultores IT</p>
                    <h1 class="text-4xl font-semibold tracking-tight text-white md:text-6xl">
                        {{ $lead->company_name }}
                    </h1>
                    <p class="max-w-3xl text-lg leading-8 text-slate-300">
                        Este diagnóstico muestra dónde puede automatizar más rápido, cuánto puede ahorrar y cuál sería el siguiente paso recomendado.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('diagnosis.client-pdf', $lead) }}" class="inline-flex items-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-100">
                        Descargar informe
                    </a>
                    <a href="https://wa.me/51941108521?text=Hola%2C%20quiero%20agendar%20una%20reuni%C3%B3n%20sobre%20mi%20diagn%C3%B3stico" target="_blank" rel="noreferrer" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                        Hablar por WhatsApp
                    </a>
                    <a href="{{ url('/diagnostico') }}" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                        Hacer otro diagnóstico
                    </a>
                    @auth
                        <a href="{{ route('exports.markdown', $lead) }}" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                            Markdown para ChatGPT
                        </a>
                        <a href="{{ route('exports.json', $lead) }}" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                            JSON estructurado
                        </a>
                    @endauth
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Fecha</p>
                    <p class="mt-2 text-2xl font-semibold text-white">{{ $reportDate }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Puntaje</p>
                    <p class="mt-2 text-4xl font-semibold text-white">{{ $lead->maturity_score }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Nivel</p>
                    <p class="mt-2 text-2xl font-semibold text-white">{{ $lead->maturity_level }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Lead scoring</p>
                    <p class="mt-2 text-xl font-semibold text-white">{{ $lead->leadScoreLabel() }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Fortalezas</p>
            <ul class="mt-2 space-y-2 text-slate-100">
                @foreach ($strengths as $strength)
                    <li>• {{ $strength }}</li>
                @endforeach
            </ul>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Oportunidades</p>
            <p class="mt-2 text-slate-100">{{ $lead->opportunities_summary }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Riesgos</p>
            <ul class="mt-2 space-y-2 text-slate-100">
                @foreach ($risks as $risk)
                    <li>• {{ $risk }}</li>
                @endforeach
            </ul>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Próximo paso</p>
            <p class="mt-2 text-slate-100">{{ $lead->nextStepRecommendation() }}</p>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Exportar para IA</p>
        <div class="mt-4 grid gap-4 lg:grid-cols-[1.1fr_0.9fr] lg:items-start">
            <div>
                <h2 class="text-2xl font-semibold text-white">Listo para ChatGPT, Claude o un agente interno</h2>
                <p class="mt-3 text-sm leading-7 text-slate-300">
                    Puedes descargar Markdown, JSON o copiar un prompt listo para pegar en un LLM y pedir análisis adicional, propuesta preliminar o roadmap.
                </p>
            </div>

            @auth
                @php
                    $chatgptPrompt = "Analiza este diagnóstico de automatización y genera un resumen ejecutivo, riesgos, oportunidades, ROI estimado, roadmap y propuesta preliminar.\n\n"
                        ."Cliente: {$lead->company_name}\n"
                        ."RUC: {$lead->ruc}\n"
                        ."Rubro: {$lead->industry}\n"
                        ."Puntaje: {$lead->maturity_score}/100\n"
                        ."Nivel: {$lead->maturity_level}\n"
                        ."Fortalezas: ".implode(', ', $strengths)."\n"
                        ."Oportunidades: {$lead->opportunities_summary}\n"
                        ."Riesgos: ".implode(', ', $risks)."\n"
                        ."Próximo paso: {$lead->nextStepRecommendation()}\n"
                        ."Horas actuales al año: {$currentHours}\n"
                        ."Horas potenciales con automatización: {$potentialHours}\n"
                        ."Ahorro anual estimado: {$savingsHours}\n";
                @endphp
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('exports.markdown', $lead) }}" class="inline-flex items-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-100">
                        Descargar Markdown
                    </a>
                    <a href="{{ route('exports.json', $lead) }}" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                        Descargar JSON
                    </a>
                    <button
                        type="button"
                        class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10"
                        data-copy-chatgpt-prompt
                        data-copy-text="{{ e($chatgptPrompt) }}"
                    >
                        Copiar prompt para ChatGPT
                    </button>
                </div>
            @else
                <p class="text-sm text-slate-400">Las exportaciones para IA están disponibles al iniciar sesión con una cuenta autorizada.</p>
            @endauth
        </div>
    </section>

    <section class="grid gap-4 lg:grid-cols-[1fr_1fr]">
        <div class="rounded-3xl border border-cyan-400/15 bg-cyan-500/10 p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">ROI estimado</p>
            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                    <p class="text-sm text-slate-400">Horas actuales al año</p>
                    <p class="mt-2 text-2xl font-semibold text-white">{{ number_format($currentHours, 1) }}</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                    <p class="text-sm text-slate-400">Horas con automatización</p>
                    <p class="mt-2 text-2xl font-semibold text-white">{{ number_format($potentialHours, 1) }}</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                    <p class="text-sm text-slate-400">Ahorro anual</p>
                    <p class="mt-2 text-2xl font-semibold text-white">{{ number_format($savingsHours, 1) }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Procesos con más oportunidad</p>
            <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-200">
                @foreach ($automationCandidates as $candidate)
                    <li>• {{ $candidate }}</li>
                @endforeach
            </ul>
            <p class="mt-4 text-sm text-slate-400">
                Estas referencias ayudan a decidir por dónde empezar el proyecto para lograr valor rápido.
            </p>
        </div>
    </section>

    <section class="grid gap-4 lg:grid-cols-[1fr_0.9fr]">
        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Siguiente paso comercial</p>
            <h2 class="mt-2 text-2xl font-semibold text-white">Generar propuesta preliminar</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300">
                Podemos preparar un resumen ejecutivo, diagnóstico, oportunidades, riesgos, ROI estimado, roadmap y alcance preliminar para usarlo en preventa o con un agente IA.
            </p>

            <div class="mt-5 flex flex-wrap gap-3">
                <form method="POST" action="{{ route('diagnosis.proposal', $lead) }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center rounded-2xl bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                        Generar propuesta preliminar
                    </button>
                </form>
                <a href="{{ route('diagnosis.client-pdf', $lead) }}" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    Descargar informe
                </a>
                @auth
                    <a href="{{ route('exports.markdown', $lead) }}" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                        Markdown para ChatGPT
                    </a>
                    <a href="{{ route('exports.json', $lead) }}" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                        JSON estructurado
                    </a>
                @endauth
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Empresas similares</p>
            <p class="mt-3 text-sm leading-7 text-slate-300">
                Empresas de minería, energía, construcción, servicios e industria pueden usar este diagnóstico para identificar oportunidades de automatización.
            </p>
            <div class="mt-5 rounded-2xl border border-dashed border-white/15 bg-slate-950/30 p-6">
                <p class="text-sm font-semibold text-white">Espacio para logos</p>
                <p class="mt-2 text-sm text-slate-400">Si más adelante se agregan logos de clientes, este bloque ya está preparado para mostrarlos aquí.</p>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-8">
        <div class="grid gap-8 lg:grid-cols-[1fr_0.95fr] lg:items-start">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Informe completo</p>
                <h2 class="mt-2 text-2xl font-semibold text-white">Completa tus datos para descargar el informe completo</h2>
                <p class="mt-3 text-sm leading-7 text-slate-300">
                    Con tus datos de contacto podemos entregar el informe completo, hacer seguimiento comercial y preparar una propuesta más precisa.
                </p>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Nombre de empresa</p>
                        <p class="mt-2 text-white">{{ $lead->company_name }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Fecha</p>
                        <p class="mt-2 text-white">{{ $reportDate }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                @if ($contactComplete)
                    <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-4 text-sm text-emerald-100">
                        Ya puedes descargar el informe completo y solicitar seguimiento.
                    </div>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <a href="{{ route('diagnosis.client-pdf', $lead) }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-100">
                            Descargar informe
                        </a>
                        <form method="POST" action="{{ route('diagnosis.proposal', $lead) }}">
                            @csrf
                            <button type="submit" class="w-full rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                                Generar propuesta preliminar
                            </button>
                        </form>
                    </div>
                @else
                    <form method="POST" action="{{ route('diagnosis.contact.update', $lead) }}" class="space-y-4">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2">
                            <label class="grid gap-2 sm:col-span-2">
                                <span class="text-sm font-medium text-slate-200">Empresa</span>
                                <input name="company_name" type="text" value="{{ old('company_name', $lead->company_name) }}" class="rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
                            </label>
                            <label class="grid gap-2">
                                <span class="text-sm font-medium text-slate-200">Nombre</span>
                                <input name="contact_name" type="text" value="{{ old('contact_name', $lead->contact_name) }}" class="rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
                            </label>
                            <label class="grid gap-2">
                                <span class="text-sm font-medium text-slate-200">Cargo</span>
                                <input name="contact_role" type="text" value="{{ old('contact_role', $lead->contact_role) }}" class="rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
                            </label>
                            <label class="grid gap-2">
                                <span class="text-sm font-medium text-slate-200">Correo</span>
                                <input name="email" type="email" value="{{ old('email', $lead->email) }}" class="rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
                            </label>
                            <label class="grid gap-2">
                                <span class="text-sm font-medium text-slate-200">Teléfono</span>
                                <input name="phone" type="text" value="{{ old('phone', $lead->phone) }}" class="rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
                            </label>
                        </div>
                        <label class="flex items-start gap-3 rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3 text-sm text-slate-300">
                            <input name="privacy_consent" type="checkbox" value="1" class="mt-1 h-4 w-4 rounded border-white/20 bg-slate-800 text-cyan-500" />
                            <span>Acepto la <a href="{{ url('/privacidad') }}" class="text-cyan-200 underline">política de privacidad</a> y autorizo el contacto comercial.</span>
                        </label>
                        @error('privacy_consent')
                            <div class="text-sm text-red-300">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="w-full rounded-2xl bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                            Completar datos y descargar informe
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-white/5 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Resultado preliminar</p>
        <div class="mt-4 grid gap-4 lg:grid-cols-4">
            <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <p class="text-sm text-slate-400">Puntaje</p>
                <p class="mt-2 text-3xl font-semibold text-white">{{ $lead->maturity_score }}/100</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <p class="text-sm text-slate-400">Nivel</p>
                <p class="mt-2 text-3xl font-semibold text-white">{{ $lead->maturity_level }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <p class="text-sm text-slate-400">Resultado</p>
                <p class="mt-2 text-lg font-semibold text-white">{{ $lead->diagnosis_brief }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <p class="text-sm text-slate-400">Próximo paso</p>
                <p class="mt-2 text-lg font-semibold text-white">{{ $lead->nextStepRecommendation() }}</p>
            </div>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Solicitar reunión</p>
            <a class="mt-3 inline-flex rounded-xl bg-emerald-500 px-4 py-2 font-semibold text-white transition hover:bg-emerald-400" href="https://wa.me/51941108521?text=Hola%2C%20quiero%20agendar%20una%20reuni%C3%B3n%20sobre%20mi%20diagn%C3%B3stico" target="_blank" rel="noreferrer">
                Agendar reunión
            </a>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Hablar por WhatsApp</p>
            <a class="mt-3 inline-flex rounded-xl border border-white/10 bg-white/5 px-4 py-2 font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10" href="https://wa.me/51941108521" target="_blank" rel="noreferrer">
                Abrir WhatsApp
            </a>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Compartir informe</p>
            <a class="mt-3 inline-flex rounded-xl border border-white/10 bg-white/5 px-4 py-2 font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10" href="{{ route('diagnosis.client-pdf', $lead) }}">
                Descargar informe
            </a>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-slate-400">Propuesta preliminar</p>
            <form method="POST" action="{{ route('diagnosis.proposal', $lead) }}">
                @csrf
                <button type="submit" class="mt-3 inline-flex rounded-xl border border-white/10 bg-white/5 px-4 py-2 font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    Generar propuesta preliminar
                </button>
            </form>
            @auth
                <div class="mt-3 flex flex-wrap gap-2">
                    <a class="inline-flex rounded-xl border border-white/10 bg-white/5 px-4 py-2 font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10" href="{{ route('exports.markdown', $lead) }}">
                        Markdown
                    </a>
                    <a class="inline-flex rounded-xl border border-white/10 bg-white/5 px-4 py-2 font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10" href="{{ route('exports.json', $lead) }}">
                        JSON
                    </a>
                </div>
            @endauth
        </div>
    </section>
</div>

<script>
(function () {
    const button = document.querySelector('[data-copy-chatgpt-prompt]');
    if (!button || !navigator.clipboard) return;

    button.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(button.dataset.copyText || '');
            const original = button.textContent;
            button.textContent = 'Copiado';
            setTimeout(() => {
                button.textContent = original;
            }, 1800);
        } catch (error) {
            console.error(error);
        }
    });
})();
</script>
@endsection
