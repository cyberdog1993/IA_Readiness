@extends('layouts.public')

@section('content')
@php
    $old = [
        'company_name' => old('company_name', ''),
        'ruc' => old('ruc', ''),
        'industry' => old('industry', ''),
        'contact_name' => old('contact_name', ''),
        'contact_role' => old('contact_role', ''),
        'email' => old('email', ''),
        'phone' => old('phone', ''),
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
@endphp

<div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr]">
    <section class="space-y-8">
        <div class="flex items-center gap-4 rounded-3xl border border-cyan-500/20 bg-cyan-500/10 px-5 py-4 shadow-lg shadow-cyan-950/20">
            <img src="{{ asset('images/consultores-it-logo.jpeg') }}" alt="Consultores IT" class="h-16 w-16 rounded-2xl bg-white/90 object-cover p-1 shadow-lg shadow-slate-950/20" loading="eager">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Consultores IT</p>
                <p class="mt-1 text-base font-medium text-white">Consultores IT Automation Platform</p>
            </div>
        </div>

        <div class="space-y-5">
            <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-white md:text-6xl">
                Diagnóstico de automatización - ¿Cómo está tu empresa?
            </h1>
            <p class="max-w-2xl text-lg leading-8 text-slate-300">
                Descubre dónde está tu operación hoy, qué se puede automatizar primero y cómo convertirlo en una propuesta concreta con impacto real.
            </p>

            <div class="flex flex-wrap gap-3">
                <a href="https://www.consultores-it.pe" target="_blank" rel="noreferrer" class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    Visitar web principal
                </a>
                <a href="mailto:julio.valdez@consultores.it" class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    Escribir por correo
                </a>
                <a href="https://wa.me/51941108521" target="_blank" rel="noreferrer" class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    Abrir WhatsApp
                </a>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Primera lectura</p>
                <p class="mt-2 text-3xl font-semibold text-white">Verás tu punto de partida</p>
                <p class="mt-1 text-sm text-slate-400">Entiende rápido si tu operación está lista para automatizar o si conviene ordenar primero.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Ahorro posible</p>
                <p class="mt-2 text-3xl font-semibold text-white">Detecta tiempo perdido</p>
                <p class="mt-1 text-sm text-slate-400">Identifica tareas manuales, duplicidad de trabajo y oportunidades con retorno tangible.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Siguiente paso</p>
                <p class="mt-2 text-3xl font-semibold text-white">Recibe una ruta clara</p>
                <p class="mt-1 text-sm text-slate-400">Obtén un enfoque para consultoría, propuesta y ejecución sin perder tiempo.</p>
            </div>
        </div>

        <div class="rounded-3xl border border-cyan-400/10 bg-cyan-500/5 p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.25em] text-cyan-200">Cómo se usa</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Formulario guiado en 4 pasos</h2>
                </div>
                <div class="rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Progreso</p>
                    <p class="text-lg font-semibold text-white"><span id="stepCounter">1</span>/4</p>
                </div>
            </div>

            <div class="mt-5 h-2 overflow-hidden rounded-full bg-white/10">
                <div id="stepBar" class="h-full rounded-full bg-gradient-to-r from-cyan-400 via-blue-500 to-emerald-400 transition-all duration-300" style="width: 25%"></div>
            </div>
        </div>

        <div class="rounded-3xl border border-emerald-400/20 bg-emerald-500/10 p-6">
            <p class="text-sm uppercase tracking-[0.25em] text-emerald-200">Accesos internos</p>
            <h2 class="mt-2 text-2xl font-semibold text-white">Consultoría y administración</h2>
            <p class="mt-2 text-sm leading-6 text-slate-300">
                El consultor interno llena la ficha por cliente y por proceso. El administrador entra al panel para revisar resultados, administrar datos y armar propuestas.
            </p>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('consulting-intake.section', ['section' => 'cliente']) }}" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-emerald-300 to-cyan-300 px-5 py-3 font-bold text-slate-950 hover:from-emerald-200 hover:to-cyan-200">
                    Formulario consultor interno
                </a>
                <a href="{{ url('/admin') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 font-bold text-white hover:border-cyan-300/40 hover:bg-white/10">
                    Administración
                </a>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-blue-950/40 backdrop-blur">
        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h2 class="text-2xl font-semibold text-white">Pre-formulario público</h2>
                <p class="mt-1 text-sm text-slate-400">Completa por partes. El puntaje se ajusta mientras avanzas.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-right">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Puntaje</p>
                <p id="scoreValue" class="text-3xl font-semibold text-white">0</p>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex items-center justify-between text-xs uppercase tracking-[0.2em] text-slate-400">
                <span>Muy bajo</span>
                <span>Listo para automatizar</span>
            </div>
            <div class="mt-2 h-3 overflow-hidden rounded-full bg-slate-800">
                <div id="scoreBar" class="h-full w-0 rounded-full bg-gradient-to-r from-rose-500 via-amber-400 to-emerald-400 transition-all duration-300"></div>
            </div>
            <div class="mt-4 grid gap-3 sm:grid-cols-[1fr_auto] sm:items-center">
                <div>
                    <p class="text-sm text-slate-400">Nivel estimado</p>
                    <p id="levelLabel" class="text-xl font-semibold text-white">Bajo</p>
                </div>
                <p id="diagnosisPreview" class="text-sm leading-6 text-slate-300">
                    Responde el primer bloque para empezar a ver la lectura de madurez.
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('leads.store') }}" class="space-y-6" data-wizard-form>
            @csrf

            <input type="hidden" name="wizard_step" value="{{ old('wizard_step', 1) }}" data-wizard-step-input>

            <div class="space-y-6">
                <div class="space-y-4" data-step-panel data-step-index="1">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Paso 1</p>
                        <h3 class="mt-1 text-lg font-semibold text-white">Datos de empresa y contacto</h3>
                    </div>

                    @foreach ([
                        ['company_name','Empresa','text','Razón social o nombre comercial.'],
                        ['ruc','RUC','text','Documento tributario o identificador fiscal.'],
                        ['industry','Rubro','text','Actividad principal de la organización.'],
                        ['contact_name','Nombre del contacto','text','Persona que responderá el diagnóstico.'],
                        ['contact_role','Cargo','text','Puesto o responsabilidad actual.'],
                        ['email','Correo','email','Correo para enviar el diagnóstico y seguimiento.'],
                        ['phone','Teléfono','text','Número móvil o fijo de contacto.'],
                        ['company_size','Tamaño de empresa','text','Ejemplo: 1-10, 11-50, 51-200, 200+.'],
                    ] as [$name, $label, $type, $help])
                        <label class="grid gap-2" data-field-wrapper="{{ $name }}">
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
                        <h3 class="mt-1 text-lg font-semibold text-white">Sistemas, integraciones y datos</h3>
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
                        <h3 class="mt-1 text-lg font-semibold text-white">Confirmación y solicitud de consultoría</h3>
                    </div>

                    <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm leading-7 text-emerald-100">
                        <p class="font-semibold text-white">Qué recibirás</p>
                        <ul class="mt-2 space-y-1 text-emerald-50/90">
                            <li>• Puntaje de madurez sobre 100</li>
                            <li>• Diagnóstico breve y oportunidades principales</li>
                            <li>• Recomendación para avanzar a preventa o ejecución</li>
                <li>• Base para propuestas, tareas y exportaciones</li>
                        </ul>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-slate-300">
                        Revisa tus respuestas y presiona <span class="font-semibold text-white">Solicitar consultoría</span>. El sistema calculará el puntaje automáticamente.
                    </div>

                    <label class="grid gap-2">
                        <span class="text-sm font-medium text-slate-200">Acepto que me contacten para el diagnóstico</span>
                        <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">
                            <input type="checkbox" checked disabled class="h-4 w-4 rounded border-white/20 bg-slate-800 text-cyan-500" />
                            Confirmo interés en recibir seguimiento comercial y técnico.
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
                    Solicitar consultoría
                </button>
            </div>
        </form>
    </section>
</div>

<script>
(function () {
    const panels = Array.from(document.querySelectorAll('[data-step-panel]'));
    const stepCounter = document.getElementById('stepCounter');
    const stepBar = document.getElementById('stepBar');
    const scoreValue = document.getElementById('scoreValue');
    const scoreBar = document.getElementById('scoreBar');
    const levelLabel = document.getElementById('levelLabel');
    const diagnosisPreview = document.getElementById('diagnosisPreview');
    const prevButton = document.querySelector('[data-step-prev]');
    const nextButton = document.querySelector('[data-step-next]');
    const submitButton = document.querySelector('[data-step-submit]');
    const form = document.querySelector('[data-wizard-form]');
    const hiddenStep = document.querySelector('[data-wizard-step-input]');
    const rangeInputs = Array.from(document.querySelectorAll('[data-range-input]'));
    const totalSteps = panels.length;
    let currentStep = 1;

    const getValue = (name) => {
        const field = form.querySelector(`[name="${name}"]`);
        if (!field) return 0;
        if (field.type === 'checkbox') {
            return field.checked ? 1 : 0;
        }

        const raw = field.value;
        const parsed = parseInt(raw, 10);
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
        let diagnosis = 'Responde el primer bloque para empezar a ver la lectura de madurez.';

        if (score <= 30) {
            level = 'Bajo';
            diagnosis = 'La operación muestra baja preparación para automatizar; conviene ordenar procesos y datos antes de invertir en automatización compleja.';
        } else if (score <= 55) {
            level = 'Inicial';
            diagnosis = 'Existen señales tempranas de automatización, pero todavía hay dependencia manual alta y poca estandarización.';
        } else if (score <= 75) {
            level = 'Intermedio';
            diagnosis = 'Hay una base viable para automatización selectiva con quick wins y mejora de integraciones.';
        } else if (score <= 90) {
            level = 'Avanzado';
            diagnosis = 'La organización está cerca de capturar valor rápido con automatizaciones asistidas por IA, n8n y MCP.';
        } else {
            level = 'Listo para automatizar';
            diagnosis = 'La organización está lista para automatizar con un enfoque por oleadas, gobierno y medición de impacto.';
        }

        return { score, level, diagnosis };
    };

    const updateScoreUI = () => {
        const { score, level, diagnosis } = evaluate();
        scoreValue.textContent = score.toString();
        scoreBar.style.width = `${score}%`;
        levelLabel.textContent = level;
        diagnosisPreview.textContent = diagnosis;
        scoreBar.className = 'h-full rounded-full transition-all duration-300';

        if (score <= 30) {
            scoreBar.classList.add('bg-rose-500');
        } else if (score <= 55) {
            scoreBar.classList.add('bg-amber-400');
        } else if (score <= 75) {
            scoreBar.classList.add('bg-sky-400');
        } else if (score <= 90) {
            scoreBar.classList.add('bg-emerald-400');
        } else {
            scoreBar.classList.add('bg-cyan-300');
        }
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
        stepCounter.textContent = currentStep.toString();
        stepBar.style.width = `${(currentStep / totalSteps) * 100}%`;
        hiddenStep.value = currentStep.toString();
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
