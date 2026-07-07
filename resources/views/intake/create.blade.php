@extends('layouts.public')

@section('content')
<div class="mx-auto max-w-6xl">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="inline-flex rounded-full border border-cyan-500/30 bg-cyan-500/10 px-4 py-2 text-sm font-medium text-cyan-200">
                Levantamiento de consultoría
            </div>
            <h1 class="mt-5 max-w-4xl text-4xl font-semibold tracking-tight text-white md:text-6xl">
                Ficha completa para entender el proceso y preparar la automatización.
            </h1>
            <p class="mt-4 max-w-3xl text-lg leading-8 text-slate-300">
                Úsalo en una entrevista interna o compártelo con el cliente. Al enviarlo se crearán el cliente, proceso, AS-IS, sistemas, documentos, problemas, oportunidades, evaluación y backlog inicial.
            </p>
        </div>
        <a href="{{ route('landing') }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-slate-100 hover:border-cyan-300/40">
            Volver al diagnóstico rápido
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-3xl border border-rose-400/30 bg-rose-500/10 p-5 text-rose-100">
            <p class="font-semibold">Revisa los campos marcados antes de enviar.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('consulting-intake.store') }}" class="space-y-6" data-intake-form>
        @csrf

        <div class="sticky top-0 z-20 -mx-6 border-b border-white/10 bg-slate-950/90 px-6 py-4 backdrop-blur">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Progreso</p>
                    <p class="mt-1 text-lg font-semibold text-white"><span data-current-step>1</span>/6 secciones</p>
                </div>
                <div class="h-2 min-w-48 flex-1 overflow-hidden rounded-full bg-white/10 lg:max-w-xl">
                    <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 via-blue-500 to-emerald-400 transition-all" data-progress-bar style="width: 16.6%"></div>
                </div>
            </div>
        </div>

        <x-intake-section step="1" title="Cliente y contacto" subtitle="Datos base para registrar o actualizar el cliente.">
            <div class="grid gap-4 md:grid-cols-2">
                <x-intake-input name="business_name" label="Razón social" required />
                <x-intake-input name="ruc" label="RUC" required />
                <x-intake-input name="industry" label="Rubro" required />
                <x-intake-input name="address" label="Dirección" />
                <x-intake-input name="main_contact" label="Contacto principal" />
                <x-intake-input name="contact_role" label="Cargo" />
                <x-intake-input name="email" label="Correo" type="email" />
                <x-intake-input name="phone" label="Teléfono" />
            </div>
            <x-intake-textarea name="client_notes" label="Observaciones del cliente" />
        </x-intake-section>

        <x-intake-section step="2" title="Proceso" subtitle="Define el proceso que será diagnosticado.">
            <div class="grid gap-4 md:grid-cols-2">
                <x-intake-input name="process_name" label="Nombre del proceso" required />
                <x-intake-input name="area" label="Área" />
                <x-intake-input name="owner" label="Responsable" />
                <x-intake-input name="frequency" label="Frecuencia" placeholder="Diario, semanal, mensual, por demanda..." />
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <x-intake-textarea name="objective" label="Objetivo del proceso" />
                <x-intake-textarea name="expected_result" label="Resultado esperado" />
                <x-intake-textarea name="trigger_event" label="Evento que inicia el proceso" />
                <x-intake-textarea name="validation_method" label="Cómo se valida que terminó correctamente" />
            </div>
        </x-intake-section>

        <x-intake-section step="3" title="AS-IS y sistemas" subtitle="Describe los pasos actuales y las plataformas involucradas.">
            <div data-repeater="steps" class="space-y-4">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-lg font-semibold text-white">Pasos AS-IS</h3>
                    <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar paso</button>
                </div>
                <div data-rows class="space-y-4">
                    <div data-row class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <div class="grid gap-4 md:grid-cols-3">
                            <x-intake-input name="steps[0][description]" label="Descripción del paso" wrapper-class="md:col-span-3" />
                            <x-intake-input name="steps[0][owner]" label="Responsable" />
                            <x-intake-input name="steps[0][system_used]" label="Sistema usado" />
                            <x-intake-input name="steps[0][estimated_minutes]" label="Minutos estimados" type="number" />
                            <x-intake-input name="steps[0][input]" label="Entrada" />
                            <x-intake-input name="steps[0][output]" label="Salida" />
                            <x-intake-input name="steps[0][evidence_generated]" label="Evidencia generada" />
                        </div>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <x-intake-textarea name="steps[0][problems]" label="Problemas del paso" />
                            <label class="grid gap-2">
                                <span class="text-sm font-semibold text-slate-200">Automatizable</span>
                                <select name="steps[0][automatable]" class="rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-cyan-400">
                                    <option value="parcial">Parcial</option>
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div data-repeater="systems" class="mt-8 space-y-4">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-lg font-semibold text-white">Sistemas involucrados</h3>
                    <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar sistema</button>
                </div>
                <div data-rows class="space-y-4">
                    <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-3">
                        <x-intake-input name="systems[0][name]" label="Nombre del sistema" />
                        <x-intake-input name="systems[0][url]" label="URL" />
                        <x-intake-input name="systems[0][system_type]" label="Tipo de sistema" />
                        <x-intake-input name="systems[0][auth_type]" label="Tipo de autenticación" />
                        <x-intake-input name="systems[0][access_owner]" label="Responsable del acceso" />
                        <x-intake-input name="systems[0][access_status]" label="Estado del acceso" placeholder="Pendiente, aprobado, bloqueado..." />
                        <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-900 px-4 py-3">
                            <input type="checkbox" name="systems[0][has_api]" value="1" class="h-5 w-5 rounded border-white/20 bg-slate-900 accent-cyan-400">
                            <span class="text-sm font-semibold text-slate-200">Tiene API</span>
                        </label>
                        <x-intake-input name="systems[0][notes]" label="Observaciones" wrapper-class="md:col-span-2" />
                    </div>
                </div>
            </div>
        </x-intake-section>

        <x-intake-section step="4" title="Evidencias y problemas" subtitle="Registra documentos, archivos, cuellos de botella y riesgos actuales.">
            <div data-repeater="documents" class="space-y-4">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-lg font-semibold text-white">Documentos y evidencias</h3>
                    <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar documento</button>
                </div>
                <div data-rows class="space-y-4">
                    <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-3">
                        <x-intake-input name="documents[0][name]" label="Nombre" />
                        <x-intake-input name="documents[0][type]" label="Tipo" />
                        <x-intake-input name="documents[0][format]" label="Formato" />
                        <x-intake-input name="documents[0][location]" label="Ubicación" />
                        <x-intake-input name="documents[0][owner]" label="Responsable" />
                        <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-900 px-4 py-3">
                            <input type="checkbox" name="documents[0][mandatory]" value="1" class="h-5 w-5 rounded border-white/20 bg-slate-900 accent-cyan-400">
                            <span class="text-sm font-semibold text-slate-200">Obligatorio</span>
                        </label>
                    </div>
                </div>
            </div>

            <div data-repeater="problems" class="mt-8 space-y-4">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-lg font-semibold text-white">Problemas actuales</h3>
                    <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar problema</button>
                </div>
                <div data-rows class="space-y-4">
                    <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-2">
                        <x-intake-textarea name="problems[0][description]" label="Descripción" />
                        <x-intake-textarea name="problems[0][comments]" label="Comentarios" />
                        <x-intake-input name="problems[0][impact]" label="Impacto" />
                        <x-intake-input name="problems[0][frequency]" label="Frecuencia" />
                        <x-intake-input name="problems[0][risk]" label="Riesgo" />
                    </div>
                </div>
            </div>
        </x-intake-section>

        <x-intake-section step="5" title="Automatización y evaluación" subtitle="Prioriza oportunidades y captura criterios técnicos internos.">
            <div data-repeater="opportunities" class="space-y-4">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-lg font-semibold text-white">Oportunidades de automatización</h3>
                    <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar oportunidad</button>
                </div>
                <div data-rows class="space-y-4">
                    <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-3">
                        <x-intake-input name="opportunities[0][activity]" label="Actividad" wrapper-class="md:col-span-3" />
                        <x-intake-input name="opportunities[0][current_time_minutes]" label="Tiempo actual min." type="number" />
                        <x-intake-input name="opportunities[0][expected_time_minutes]" label="Tiempo esperado min." type="number" />
                        <x-intake-input name="opportunities[0][suggested_technology]" label="Tecnología sugerida" placeholder="Hermes Agent, MCP, n8n, IA, RPA, API, OCR" />
                        <x-intake-input name="opportunities[0][priority]" label="Prioridad" placeholder="Alta, media, baja" />
                        <x-intake-input name="opportunities[0][complexity]" label="Complejidad 1-5" type="number" />
                        <x-intake-input name="opportunities[0][notes]" label="Notas" />
                    </div>
                </div>
            </div>

            <div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-5">
                <h3 class="text-lg font-semibold text-white">Evaluación interna</h3>
                <div class="mt-4 grid gap-4 md:grid-cols-4">
                    <x-intake-input name="evaluation[complexity]" label="Complejidad 1-5" type="number" />
                    <x-intake-input name="evaluation[risk]" label="Riesgo 1-5" type="number" />
                    <x-intake-input name="evaluation[impact]" label="Impacto 1-5" type="number" />
                    <x-intake-input name="evaluation[estimated_hours]" label="Horas estimadas" type="number" />
                </div>
                <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
                    @foreach ([
                        'requires_mcp' => 'Requiere MCP',
                        'requires_hermes_skill' => 'Requiere Skill Hermes',
                        'requires_n8n' => 'Requiere n8n',
                        'requires_ai' => 'Requiere IA',
                        'requires_ocr' => 'Requiere OCR',
                    ] as $name => $label)
                        <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-900 px-4 py-3">
                            <input type="checkbox" name="evaluation[{{ $name }}]" value="1" class="h-5 w-5 rounded border-white/20 bg-slate-900 accent-cyan-400">
                            <span class="text-sm font-semibold text-slate-200">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="mt-4">
                    <x-intake-textarea name="evaluation[technical_notes]" label="Observaciones técnicas" />
                </div>
            </div>
        </x-intake-section>

        <x-intake-section step="6" title="Backlog inicial" subtitle="Convierte el levantamiento en trabajo accionable.">
            <div data-repeater="backlog" class="space-y-4">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-lg font-semibold text-white">Backlog sugerido</h3>
                    <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar item</button>
                </div>
                <div data-rows class="space-y-4">
                    <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-3">
                        <x-intake-input name="backlog[0][type]" label="Tipo" placeholder="Historia, tarea técnica, integración..." />
                        <x-intake-input name="backlog[0][title]" label="Título" wrapper-class="md:col-span-2" />
                        <x-intake-textarea name="backlog[0][description]" label="Descripción" />
                        <x-intake-textarea name="backlog[0][acceptance_criteria]" label="Criterios de aceptación" />
                        <div class="grid gap-4">
                            <x-intake-input name="backlog[0][priority]" label="Prioridad" />
                            <x-intake-input name="backlog[0][responsible]" label="Responsable" />
                            <x-intake-input name="backlog[0][estimated_hours]" label="Horas estimadas" type="number" />
                        </div>
                    </div>
                </div>
            </div>
        </x-intake-section>

        <div class="flex flex-col gap-3 rounded-3xl border border-cyan-400/20 bg-cyan-500/10 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-cyan-200">Listo</p>
                <p class="mt-1 text-xl font-semibold text-white">Guardar levantamiento completo</p>
            </div>
            <button type="submit" class="rounded-2xl bg-gradient-to-r from-cyan-400 to-blue-500 px-6 py-4 font-bold text-slate-950 shadow-xl shadow-cyan-950/30 hover:from-cyan-300 hover:to-blue-400">
                Crear ficha de consultoría
            </button>
        </div>
    </form>
</div>

<script>
    const sections = [...document.querySelectorAll('[data-intake-section]')];
    const currentStep = document.querySelector('[data-current-step]');
    const progressBar = document.querySelector('[data-progress-bar]');

    const updateProgress = () => {
        const viewportMiddle = window.scrollY + window.innerHeight * 0.35;
        let active = 1;
        sections.forEach((section, index) => {
            if (section.offsetTop <= viewportMiddle) {
                active = index + 1;
            }
        });
        currentStep.textContent = active;
        progressBar.style.width = `${(active / sections.length) * 100}%`;
    };

    document.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();

    document.querySelectorAll('[data-repeater]').forEach((repeater) => {
        const rows = repeater.querySelector('[data-rows]');
        const firstRow = rows.querySelector('[data-row]');
        const button = repeater.querySelector('[data-add-row]');

        button.addEventListener('click', () => {
            const index = rows.querySelectorAll('[data-row]').length;
            const clone = firstRow.cloneNode(true);
            clone.querySelectorAll('input, textarea, select').forEach((field) => {
                field.name = field.name.replace(/\[\d+\]/, `[${index}]`);
                if (field.type === 'checkbox') {
                    field.checked = false;
                } else {
                    field.value = '';
                }
            });
            rows.appendChild(clone);
        });
    });
</script>
@endsection
