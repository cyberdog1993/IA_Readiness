@extends('layouts.public')

@section('title', 'Evaluación de Madurez para Automatización Inteligente')
@section('meta_description', 'Descubra en 10 minutos qué procesos de su empresa pueden automatizarse con IA y cuál sería el ahorro potencial.')
@section('og_title', 'Evaluación de Madurez para Automatización Inteligente')
@section('og_description', 'Diagnóstico comercial y técnico para detectar oportunidades de automatización, estimar ahorro y preparar una propuesta.')

@section('content')
@php
    $old = [
        'company_name' => old('company_name', ''),
        'ruc' => old('ruc', ''),
        'industry' => old('industry', ''),
        'company_size' => old('company_size', ''),
        'repetitive_process_count' => old('repetitive_process_count', 0),
        'manual_hours_weekly' => old('manual_hours_weekly', 0),
        'process_documentation_level' => old('process_documentation_level', 0),
        'digital_system_usage' => old('digital_system_usage', 0),
        'excel_dependency' => old('excel_dependency', 0),
        'system_integration_level' => old('system_integration_level', 0),
        'manual_report_generation' => old('manual_report_generation', 0),
        'has_kpis' => old('has_kpis', '1'),
        'key_person_dependency' => old('key_person_dependency', 0),
        'automation_interest' => old('automation_interest', 0),
    ];

    $videoUrl = config('services.landing.video_url');
    $videoMp4 = config('services.landing.video_mp4');
@endphp

<div class="grid gap-10 xl:grid-cols-[1.05fr_0.95fr] xl:items-start">
    <section class="space-y-8">
        <div class="inline-flex items-center rounded-full border border-cyan-400/20 bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-100">
            Evaluación de Madurez para Automatización Inteligente
        </div>

        <div class="space-y-5">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-200">AI Automation Assessment by Consultores IT</p>
            <h1 class="max-w-4xl text-4xl font-semibold tracking-tight text-white md:text-6xl">
                Descubra en 10 minutos qué procesos de su empresa pueden automatizarse con IA y cuál sería el ahorro potencial.
            </h1>
            <p class="max-w-3xl text-lg leading-8 text-slate-300">
                Reciba un diagnóstico claro, un puntaje de madurez, recomendaciones con IA y una base comercial lista para consultoría, propuesta o ejecución.
            </p>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                '10 minutos',
                'Sin costo',
                'Informe personalizado',
                'Recomendaciones con IA',
            ] as $badge)
                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/20">
                    {{ $badge }}
                </div>
            @endforeach
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">Problema</p>
                <p class="mt-2 text-xl font-semibold text-white">Tareas manuales, reportes repetidos y trabajo disperso entre sistemas.</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">Solución</p>
                <p class="mt-2 text-xl font-semibold text-white">Un diagnóstico guiado que prioriza automatización, ahorro y retorno.</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-400">Beneficio</p>
                <p class="mt-2 text-xl font-semibold text-white">Sale con una lectura comercial útil para avanzar sin perder tiempo.</p>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="rounded-3xl border border-cyan-400/15 bg-cyan-500/10 p-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Ejemplos de automatización</p>
                        <h2 class="mt-2 text-2xl font-semibold text-white">Procesos que suelen mostrar valor rápido</h2>
                    </div>
                </div>
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ([
                        'Generación de propuestas comerciales',
                        'Reportes automáticos',
                        'Órdenes de compra',
                        'Atención al cliente',
                        'Control documental',
                        'Seguimiento comercial',
                        'Consolidación de información en Excel',
                        'Alertas operativas',
                    ] as $item)
                        <span class="rounded-full border border-white/10 bg-slate-950/40 px-3 py-2 text-sm text-slate-100">{{ $item }}</span>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Prueba social</p>
                <p class="mt-3 text-sm leading-7 text-slate-300">
                    Empresas de minería, energía, construcción, servicios e industria pueden usar este diagnóstico para identificar oportunidades de automatización.
                </p>
                <div class="mt-5 rounded-2xl border border-dashed border-white/15 bg-slate-950/30 p-5">
                    <p class="text-sm font-semibold text-white">Espacio para logos</p>
                    <p class="mt-2 text-sm text-slate-400">Si más adelante deseas mostrar clientes o aliados, este bloque ya está preparado.</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Video explicativo</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Espacio para un video de 45 a 60 segundos</h2>
                </div>
            </div>
            <div class="mt-5 overflow-hidden rounded-3xl border border-white/10 bg-slate-950/60">
                @if ($videoUrl)
                    <iframe class="aspect-video w-full" src="{{ $videoUrl }}" title="Video explicativo" allowfullscreen></iframe>
                @elseif ($videoMp4)
                    <video class="aspect-video w-full" controls>
                        <source src="{{ $videoMp4 }}" type="video/mp4">
                    </video>
                @else
                    <div class="flex aspect-video items-center justify-center px-6 text-center">
                        <div>
                            <p class="text-sm uppercase tracking-[0.28em] text-cyan-200">Placeholder</p>
                            <p class="mt-3 text-lg text-slate-300">Aquí puedes colocar un video de YouTube, un MP4 o dejar el espacio listo para más adelante.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Lo que entrega</p>
                <p class="mt-2 text-2xl font-semibold text-white">Resultado preliminar</p>
                <p class="mt-1 text-sm text-slate-400">Puntaje, nivel, fortalezas, riesgos, oportunidades y próximos pasos.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Lo que ahorra</p>
                <p class="mt-2 text-2xl font-semibold text-white">Tiempo y esfuerzo</p>
                <p class="mt-1 text-sm text-slate-400">Permite ubicar dónde se pierde horas al año y qué automatizar primero.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Lo que sigue</p>
                <p class="mt-2 text-2xl font-semibold text-white">Propuesta preliminar</p>
                <p class="mt-1 text-sm text-slate-400">JSON, Markdown y ruta lista para n8n o un agente IA.</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('diagnosis.form') }}" data-track-event="cta_request_diagnosis" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-400 to-blue-500 px-6 py-3 font-bold text-slate-950 shadow-xl shadow-cyan-950/30">
                Solicitar diagnóstico
            </a>
        </div>
    </section>

    <aside class="space-y-5 rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-blue-950/30 backdrop-blur">
        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-5">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Pre-formulario público</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Empiece por el diagnóstico</h2>
                </div>
                <div class="rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3 text-right">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Puntaje</p>
                    <p id="scoreValue" class="text-3xl font-semibold text-white">0</p>
                </div>
            </div>
            <div class="mt-5 grid gap-3">
                <div class="flex items-center justify-between text-xs uppercase tracking-[0.2em] text-slate-400">
                    <span>Bajo</span>
                    <span>Listo para automatizar</span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-slate-800">
                    <div id="scoreBar" class="h-full w-0 rounded-full bg-gradient-to-r from-rose-500 via-amber-400 to-emerald-400 transition-all duration-300"></div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Avance</p>
                    <p id="progressText" class="mt-1 text-sm font-semibold text-white">25% completado — tiempo restante aproximado: 8 minutos</p>
                    <p id="stepText" class="mt-2 text-xs uppercase tracking-[0.2em] text-cyan-200">Paso 1 de 4</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Nivel estimado</p>
                    <p id="levelLabel" class="mt-1 text-lg font-semibold text-white">Bajo</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('leads.store') }}" class="space-y-6" data-wizard-form data-track-form="diagnostico">
            @csrf
            <input type="hidden" name="wizard_step" value="{{ old('wizard_step', 1) }}" data-wizard-step-input>

            <div class="space-y-6">
                <div class="space-y-4" data-step-panel data-step-index="1">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Paso 1</p>
                        <h3 class="mt-1 text-lg font-semibold text-white">Datos de empresa</h3>
                    </div>

                    @foreach ([
                        ['company_name','Empresa','text','Razón social o nombre comercial.'],
                        ['ruc','RUC','text','Documento tributario o identificador fiscal.'],
                        ['industry','Rubro','text','Actividad principal de la organización.'],
                        ['company_size','Tamaño de empresa','text','Ejemplo: 1-10, 11-50, 51-200, 200+.'],
                    ] as [$name, $label, $type, $help])
                        <label class="grid gap-2">
                            <span class="text-sm font-medium text-slate-200">{{ $label }}</span>
                            <input
                                name="{{ $name }}"
                                type="{{ $type }}"
                                value="{{ $old[$name] }}"
                                class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400"
                                placeholder="{{ $help }}"
                            />
                            <span class="text-xs text-slate-500">{{ $help }}</span>
                            @error($name)
                                <span class="text-sm text-red-300">{{ $message }}</span>
                            @enderror
                        </label>
                    @endforeach
                </div>

                <div class="hidden space-y-4" data-step-panel data-step-index="2">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Paso 2</p>
                        <h3 class="mt-1 text-lg font-semibold text-white">Operación manual y documentación</h3>
                    </div>

                    <label class="grid gap-2">
                        <span class="text-sm font-medium text-slate-200">Cantidad de procesos repetitivos</span>
                        <input name="repetitive_process_count" type="number" min="0" max="1000" value="{{ $old['repetitive_process_count'] }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-cyan-400" />
                        @error('repetitive_process_count')
                            <span class="text-sm text-red-300">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-sm font-medium text-slate-200">Horas semanales dedicadas a tareas manuales</span>
                        <input name="manual_hours_weekly" type="number" min="0" max="10000" value="{{ $old['manual_hours_weekly'] }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-cyan-400" />
                        @error('manual_hours_weekly')
                            <span class="text-sm text-red-300">{{ $message }}</span>
                        @enderror
                    </label>

                    @foreach ([
                        ['process_documentation_level','Nivel de documentación de procesos'],
                        ['manual_report_generation','Generación manual de reportes'],
                        ['excel_dependency','Uso crítico de Excel'],
                        ['key_person_dependency','Dependencia de personas clave'],
                    ] as [$name, $label])
                        <label class="grid gap-2">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-sm font-medium text-slate-200">{{ $label }}</span>
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-200"><span data-range-value-for="{{ $name }}">{{ $old[$name] }}</span>/100</span>
                            </div>
                            <input
                                name="{{ $name }}"
                                type="range"
                                min="0"
                                max="100"
                                value="{{ $old[$name] }}"
                                class="w-full accent-cyan-400"
                                data-range-input
                            />
                            @error($name)
                                <span class="text-sm text-red-300">{{ $message }}</span>
                            @enderror
                        </label>
                    @endforeach
                </div>

                <div class="hidden space-y-4" data-step-panel data-step-index="3">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Paso 3</p>
                        <h3 class="mt-1 text-lg font-semibold text-white">Sistemas, integraciones y madurez digital</h3>
                    </div>

                    @foreach ([
                        ['digital_system_usage','Uso de sistemas digitales'],
                        ['system_integration_level','Integración entre sistemas'],
                        ['automation_interest','Interés en automatizar'],
                    ] as [$name, $label])
                        <label class="grid gap-2">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-sm font-medium text-slate-200">{{ $label }}</span>
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-200"><span data-range-value-for="{{ $name }}">{{ $old[$name] }}</span>/100</span>
                            </div>
                            <input
                                name="{{ $name }}"
                                type="range"
                                min="0"
                                max="100"
                                value="{{ $old[$name] }}"
                                class="w-full accent-cyan-400"
                                data-range-input
                            />
                            @error($name)
                                <span class="text-sm text-red-300">{{ $message }}</span>
                            @enderror
                        </label>
                    @endforeach

                    <label class="grid gap-2">
                        <span class="text-sm font-medium text-slate-200">Existencia de KPIs</span>
                        <select name="has_kpis" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-cyan-400">
                            <option value="1" @selected($old['has_kpis'] == '1')>Sí</option>
                            <option value="0" @selected($old['has_kpis'] === '0')>No</option>
                        </select>
                        @error('has_kpis')
                            <span class="text-sm text-red-300">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <div class="hidden space-y-4" data-step-panel data-step-index="4">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Paso 4</p>
                        <h3 class="mt-1 text-lg font-semibold text-white">Confirmación y envío del diagnóstico</h3>
                    </div>

                    <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm leading-7 text-emerald-100">
                        <p class="font-semibold text-white">Qué recibirá</p>
                        <ul class="mt-2 space-y-1 text-emerald-50/90">
                            <li>• Puntaje de madurez sobre 100</li>
                            <li>• Nivel estimado: Bajo, Medio o Alto</li>
                            <li>• Oportunidades principales y riesgos detectados</li>
                            <li>• Base para propuesta, backlog y exportaciones</li>
                        </ul>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-slate-300">
                        Revise la información y presione <span class="font-semibold text-white">Solicitar diagnóstico</span>. El resultado preliminar se mostrará al instante.
                    </div>

                    <label class="grid gap-2">
                        <span class="text-sm font-medium text-slate-200">Consentimiento comercial y privacidad</span>
                        <div class="space-y-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">
                            <label class="flex items-start gap-3">
                                <input name="privacy_consent" type="checkbox" value="1" class="mt-1 h-4 w-4 rounded border-white/20 bg-slate-800 text-cyan-500" @checked(old('privacy_consent')) />
                                <span>Acepto la <a href="{{ url('/privacidad') }}" class="text-cyan-200 underline">política de privacidad</a> y autorizo que me contacten sobre este diagnóstico.</span>
                            </label>
                            @error('privacy_consent')
                                <span class="text-sm text-red-300">{{ $message }}</span>
                            @enderror
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="button" class="hidden rounded-2xl border border-white/10 bg-white/5 px-5 py-3 font-semibold text-white transition hover:bg-white/10" data-step-prev>
                    Anterior
                </button>
                <button type="button" class="rounded-2xl bg-cyan-500 px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-400" data-step-next>
                    Siguiente
                </button>
                <button type="submit" class="hidden rounded-2xl bg-emerald-500 px-5 py-3 font-semibold text-white transition hover:bg-emerald-400" data-step-submit>
                    Solicitar diagnóstico
                </button>
            </div>
        </form>
    </aside>
</div>

<script>
(function () {
    const panels = Array.from(document.querySelectorAll('[data-step-panel]'));
    const stepText = document.getElementById('stepText');
    const progressText = document.getElementById('progressText');
    const levelLabel = document.getElementById('levelLabel');
    const scoreValue = document.getElementById('scoreValue');
    const scoreBar = document.getElementById('scoreBar');
    const prevButton = document.querySelector('[data-step-prev]');
    const nextButton = document.querySelector('[data-step-next]');
    const submitButton = document.querySelector('[data-step-submit]');
    const form = document.querySelector('[data-wizard-form]');
    const hiddenStep = document.querySelector('[data-wizard-step-input]');
    const rangeInputs = Array.from(document.querySelectorAll('[data-range-input]'));
    const totalSteps = panels.length;
    const totalMinutes = 10;
    let currentStep = 1;

    const getValue = (name) => {
        const field = form.querySelector(`[name="${name}"]`);
        if (!field) return 0;

        if (field.type === 'checkbox') {
            return field.checked ? 1 : 0;
        }

        const parsed = parseInt(field.value, 10);
        return Number.isFinite(parsed) ? parsed : 0;
    };

    const scoreRepetitiveness = () => {
        const repetitive = getValue('repetitive_process_count');
        const manualHours = getValue('manual_hours_weekly');
        const excel = getValue('excel_dependency');
        const reports = getValue('manual_report_generation');

        return Math.round(Math.min(100, (
            Math.min(repetitive, 20) * 3 +
            Math.min(manualHours, 40) * 1.2 +
            excel * 0.15 +
            reports * 0.15
        )));
    };

    const scoreDataQuality = () => {
        const systemUsage = getValue('digital_system_usage');
        const integration = getValue('system_integration_level');
        const excel = getValue('excel_dependency');
        const manualReports = getValue('manual_report_generation');

        return Math.round(Math.max(0, Math.min(100, 100 - ((excel * 0.4) + (manualReports * 0.3)) + ((systemUsage + integration) * 0.25))));
    };

    const scoreKpis = () => (getValue('has_kpis') ? 100 : 20);

    const scoreOperationalVolume = () => {
        const repetitive = getValue('repetitive_process_count');
        const hours = getValue('manual_hours_weekly');

        return Math.round(Math.min(100, (repetitive * 2.5) + (hours * 2)));
    };

    const scoreCulture = () => {
        const interest = getValue('automation_interest');
        const keyPeople = getValue('key_person_dependency');

        return Math.round(Math.max(0, Math.min(100, (interest * 0.7) + ((100 - keyPeople) * 0.3))));
    };

    const evaluate = () => {
        const scores = {
            processes_documented: getValue('process_documentation_level'),
            task_repetitiveness: scoreRepetitiveness(),
            digital_system_usage: getValue('digital_system_usage'),
            system_integration: getValue('system_integration_level'),
            data_quality: scoreDataQuality(),
            kpi_measurement: scoreKpis(),
            operational_volume: scoreOperationalVolume(),
            cultural_readiness: scoreCulture(),
        };

        const weighted = (
            scores.processes_documented * 0.15 +
            scores.task_repetitiveness * 0.15 +
            scores.digital_system_usage * 0.15 +
            scores.system_integration * 0.15 +
            scores.data_quality * 0.15 +
            scores.kpi_measurement * 0.10 +
            scores.operational_volume * 0.10 +
            scores.cultural_readiness * 0.05
        );

        const score = Math.max(0, Math.min(100, Math.round(weighted)));
        let level = 'Bajo';

        if (score <= 39) {
            level = 'Bajo';
        } else if (score <= 69) {
            level = 'Medio';
        } else {
            level = 'Alto';
        }

        return { score, level };
    };

    const updateScoreUI = () => {
        const { score, level } = evaluate();
        scoreValue.textContent = score.toString();
        scoreBar.style.width = `${score}%`;
        scoreBar.className = 'h-full rounded-full transition-all duration-300';

        if (score <= 39) {
            scoreBar.classList.add('bg-rose-500');
        } else if (score <= 69) {
            scoreBar.classList.add('bg-amber-400');
        } else {
            scoreBar.classList.add('bg-emerald-400');
        }

        const percent = Math.round((currentStep / totalSteps) * 100);
        const remaining = Math.max(0, Math.round(((totalSteps - currentStep) / totalSteps) * totalMinutes));

        stepText.textContent = `Paso ${currentStep} de ${totalSteps}`;
        progressText.textContent = `${percent}% completado — tiempo restante aproximado: ${remaining} minutos`;
        levelLabel.textContent = level;
        scoreBar.dataset.level = level;
    };

    const syncRangeLabels = () => {
        rangeInputs.forEach((input) => {
            const target = document.querySelector(`[data-range-value-for="${input.name}"]`);
            if (target) {
                target.textContent = input.value;
            }
        });
    };

    const showStep = (step) => {
        currentStep = Math.max(1, Math.min(totalSteps, step));
        panels.forEach((panel) => {
            panel.classList.toggle('hidden', Number(panel.dataset.stepIndex) !== currentStep);
        });

        prevButton.classList.toggle('hidden', currentStep === 1);
        nextButton.classList.toggle('hidden', currentStep === totalSteps);
        submitButton.classList.toggle('hidden', currentStep !== totalSteps);
        hiddenStep.value = currentStep.toString();
        updateScoreUI();
    };

    prevButton?.addEventListener('click', () => showStep(currentStep - 1));
    nextButton?.addEventListener('click', () => showStep(currentStep + 1));

    rangeInputs.forEach((input) => input.addEventListener('input', () => {
        syncRangeLabels();
        updateScoreUI();
    }));

    form.addEventListener('input', updateScoreUI);

    showStep(Number(hiddenStep?.value || 1));
    syncRangeLabels();
    updateScoreUI();
})();
</script>
@endsection
