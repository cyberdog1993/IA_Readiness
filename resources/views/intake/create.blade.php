@extends('layouts.public')

@section('content')
@php
    $flow = [
        'cliente' => ['title' => 'Cliente y contacto', 'subtitle' => 'Datos base para registrar o actualizar el cliente.'],
        'proceso' => ['title' => 'Proceso', 'subtitle' => 'Define el proceso que será diagnosticado.'],
        'as-is' => ['title' => 'AS-IS y sistemas', 'subtitle' => 'Describe los pasos actuales y las plataformas involucradas.'],
        'documentos' => ['title' => 'Evidencias y problemas', 'subtitle' => 'Registra documentos, archivos, cuellos de botella y riesgos actuales.'],
        'automatizacion' => ['title' => 'Automatización y evaluación', 'subtitle' => 'Prioriza oportunidades y captura criterios técnicos internos.'],
        'tareas' => ['title' => 'Tareas iniciales', 'subtitle' => 'Convierte el levantamiento en trabajo accionable.'],
    ];

    $order = array_keys($flow);
    $position = array_search($section, $order, true) + 1;
    $total = count($order);
    $previous = $position > 1 ? $order[$position - 2] : null;
    $next = $position < $total ? $order[$position] : null;
    $client = $client ?? null;
    $process = $process ?? null;
    $selectedLead = $selectedLead ?? null;

    $prefill = [
        'business_name' => old('business_name', $client?->business_name ?? $selectedLead?->company_name ?? ''),
        'ruc' => old('ruc', $client?->ruc ?? $selectedLead?->ruc ?? ''),
        'industry' => old('industry', $client?->industry ?? $selectedLead?->industry ?? ''),
        'address' => old('address', $client?->address ?? ''),
        'main_contact' => old('main_contact', $client?->main_contact ?? $selectedLead?->contact_name ?? ''),
        'contact_role' => old('contact_role', $client?->contact_role ?? $selectedLead?->contact_role ?? ''),
        'email' => old('email', $client?->email ?? $selectedLead?->email ?? ''),
        'phone' => old('phone', $client?->phone ?? $selectedLead?->phone ?? ''),
        'client_notes' => old('client_notes', $client?->notes ?? ''),
    ];
@endphp

<div class="mx-auto max-w-5xl">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="inline-flex rounded-full border border-cyan-500/30 bg-cyan-500/10 px-4 py-2 text-sm font-medium text-cyan-200">
                Levantamiento de consultoría
            </div>
            <h1 class="mt-5 max-w-4xl text-4xl font-semibold tracking-tight text-white md:text-6xl">
                Una ficha por proceso, dentro de cada cliente.
            </h1>
            <p class="mt-4 max-w-3xl text-lg leading-8 text-slate-300">
                Se guarda una sección por página para que puedas avanzar por partes y no perder información.
            </p>
        </div>
        <a href="{{ route('landing') }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-slate-100 hover:border-cyan-300/40">
            Volver al diagnóstico rápido
        </a>
    </div>

    @if ($client)
        <div class="mb-6 rounded-3xl border border-cyan-400/20 bg-cyan-500/10 p-5 text-cyan-50">
            <p class="text-sm uppercase tracking-[0.2em] text-cyan-200">Cliente detectado</p>
            <p class="mt-2 text-lg font-semibold text-white">{{ $client->business_name }}</p>
            <p class="mt-1 text-sm text-cyan-50/90">RUC {{ $client->ruc }} · {{ $client->processes_count }} proceso{{ $client->processes_count === 1 ? '' : 's' }} registrado{{ $client->processes_count === 1 ? '' : 's' }}.</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-3xl border border-rose-400/30 bg-rose-500/10 p-5 text-rose-100">
            <p class="font-semibold">Revisa los campos marcados antes de continuar.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 rounded-3xl border border-white/10 bg-slate-900/80 p-5">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Progreso</p>
                <h2 class="mt-2 text-2xl font-semibold text-white">{{ $flow[$section]['title'] }}</h2>
                <p class="mt-1 text-sm text-slate-400">{{ $flow[$section]['subtitle'] }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-right">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Paso</p>
                <p class="text-3xl font-semibold text-white">{{ $position }}</p>
                <p class="text-xs text-slate-400">de {{ $total }}</p>
            </div>
        </div>
        <div class="mt-4 h-2 overflow-hidden rounded-full bg-white/10">
            <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 via-blue-500 to-emerald-400" style="width: {{ ($position / $total) * 100 }}%"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('consulting-intake.store', ['section' => $section]) }}" class="space-y-6" data-intake-form>
        @csrf

        @if ($section === 'cliente')
            <x-intake-section step="1" title="Cliente y contacto" subtitle="Datos base para registrar o actualizar el cliente.">
                <input type="hidden" name="lead_id" value="{{ old('lead_id', $selectedLead?->id) }}">

                <div class="rounded-3xl border border-cyan-400/20 bg-cyan-500/10 p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Traer datos del pre-formulario</p>
                            <h3 class="mt-2 text-xl font-semibold text-white">Selecciona un lead para continuar la consultoría</h3>
                            <p class="mt-1 text-sm text-cyan-50/80">Si el cliente ya completó el diagnóstico rápido, puedes reutilizar esa información y ahorrar tiempo.</p>
                        </div>
                        <div class="min-w-[280px]">
                            <label class="grid gap-2">
                                <span class="text-sm font-semibold text-cyan-100">Lead disponible</span>
                                <select data-lead-picker class="rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-cyan-400">
                                    <option value="">Elegir un lead reciente</option>
                                    @foreach ($leads as $lead)
                                        <option value="{{ $lead->id }}" @selected($selectedLead?->id === $lead->id)>
                                            {{ $lead->company_name }} - {{ $lead->maturity_score }} pts
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>

                    @if ($selectedLead)
                        <div class="mt-5 grid gap-4 md:grid-cols-4">
                            <div class="rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                                <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Empresa</p>
                                <p class="mt-2 text-lg font-semibold text-white">{{ $selectedLead->company_name }}</p>
                                <p class="mt-1 text-sm text-slate-300">RUC {{ $selectedLead->ruc }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                                <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Puntaje</p>
                                <p class="mt-2 text-lg font-semibold text-white">{{ $selectedLead->maturity_score ?? 0 }} / 100</p>
                                <p class="mt-1 text-sm text-slate-300">{{ $selectedLead->maturity_level }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                                <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Contacto</p>
                                <p class="mt-2 text-lg font-semibold text-white">{{ $selectedLead->contact_name }}</p>
                                <p class="mt-1 text-sm text-slate-300">{{ $selectedLead->contact_role }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                                <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Estado</p>
                                <p class="mt-2 text-lg font-semibold text-white">{{ $selectedLead->status }}</p>
                                <p class="mt-1 text-sm text-slate-300">{{ $selectedLead->email }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <x-intake-input name="business_name" label="Razón social" value="{{ $prefill['business_name'] }}" required />
                    <x-intake-input name="ruc" label="RUC" value="{{ $prefill['ruc'] }}" required />
                    <x-intake-input name="industry" label="Rubro" value="{{ $prefill['industry'] }}" required />
                    <x-intake-input name="address" label="Dirección" value="{{ $prefill['address'] }}" />
                    <x-intake-input name="main_contact" label="Contacto principal" value="{{ $prefill['main_contact'] }}" />
                    <x-intake-input name="contact_role" label="Cargo" value="{{ $prefill['contact_role'] }}" />
                    <x-intake-input name="email" label="Correo" type="email" value="{{ $prefill['email'] }}" />
                    <x-intake-input name="phone" label="Teléfono" value="{{ $prefill['phone'] }}" />
                </div>
                <x-intake-textarea name="client_notes" label="Observaciones del cliente" value="{{ $prefill['client_notes'] }}" />
            </x-intake-section>
        @elseif ($section === 'proceso')
            <x-intake-section step="2" title="Proceso" subtitle="Define el proceso que será diagnosticado.">
                <div class="grid gap-4 md:grid-cols-2">
                    <x-intake-input name="process_name" label="Nombre del proceso" value="{{ old('process_name', $process?->name) }}" required />
                    <x-intake-input name="area" label="Área" value="{{ old('area', $process?->area) }}" />
                    <x-intake-input name="owner" label="Responsable" value="{{ old('owner', $process?->owner) }}" />
                    <x-intake-input name="frequency" label="Frecuencia" value="{{ old('frequency', $process?->frequency) }}" placeholder="Diario, semanal, mensual, por demanda..." />
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <x-intake-textarea name="objective" label="Objetivo del proceso" value="{{ old('objective', $process?->objective) }}" />
                    <x-intake-textarea name="expected_result" label="Resultado esperado" value="{{ old('expected_result', $process?->expected_result) }}" />
                    <x-intake-textarea name="trigger_event" label="Evento que inicia el proceso" value="{{ old('trigger_event', $process?->trigger_event) }}" />
                    <x-intake-textarea name="validation_method" label="Cómo se valida que terminó correctamente" value="{{ old('validation_method', $process?->validation_method) }}" />
                </div>
            </x-intake-section>
        @elseif ($section === 'as-is')
            @php
                $steps = old('steps', $process?->steps?->map(fn ($step) => [
                    'description' => $step->description,
                    'owner' => $step->owner,
                    'system_used' => $step->system_used,
                    'estimated_minutes' => $step->estimated_minutes,
                    'input' => $step->input,
                    'output' => $step->output,
                    'evidence_generated' => $step->evidence_generated,
                    'problems' => $step->problems,
                    'automatable' => $step->automatable,
                    'comments' => $step->comments,
                ])->values()->all() ?: [[]]);

                $systems = old('systems', $process?->systems?->map(fn ($system) => [
                    'name' => $system->name,
                    'url' => $system->url,
                    'system_type' => $system->system_type,
                    'auth_type' => $system->auth_type,
                    'access_owner' => $system->access_owner,
                    'access_status' => $system->access_status,
                    'has_api' => $system->has_api,
                    'notes' => $system->notes,
                ])->values()->all() ?: [[]]);
            @endphp
            <x-intake-section step="3" title="AS-IS y sistemas" subtitle="Describe los pasos actuales y las plataformas involucradas.">
                <div data-repeater="steps" class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-lg font-semibold text-white">Pasos AS-IS</h3>
                        <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar paso</button>
                    </div>
                    <div data-rows class="space-y-4">
                        @foreach ($steps as $index => $step)
                            <div data-row class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                <div class="grid gap-4 md:grid-cols-3">
                                    <x-intake-input name="steps[{{ $index }}][description]" label="Descripción del paso" value="{{ $step['description'] ?? '' }}" wrapper-class="md:col-span-3" />
                                    <x-intake-input name="steps[{{ $index }}][owner]" label="Responsable" value="{{ $step['owner'] ?? '' }}" />
                                    <x-intake-input name="steps[{{ $index }}][system_used]" label="Sistema usado" value="{{ $step['system_used'] ?? '' }}" />
                                    <x-intake-input name="steps[{{ $index }}][estimated_minutes]" label="Minutos estimados" type="number" value="{{ $step['estimated_minutes'] ?? '' }}" />
                                    <x-intake-input name="steps[{{ $index }}][input]" label="Entrada" value="{{ $step['input'] ?? '' }}" />
                                    <x-intake-input name="steps[{{ $index }}][output]" label="Salida" value="{{ $step['output'] ?? '' }}" />
                                    <x-intake-input name="steps[{{ $index }}][evidence_generated]" label="Evidencia generada" value="{{ $step['evidence_generated'] ?? '' }}" />
                                </div>
                                <div class="mt-4 grid gap-4 md:grid-cols-2">
                                    <x-intake-textarea name="steps[{{ $index }}][problems]" label="Problemas del paso" value="{{ $step['problems'] ?? '' }}" />
                                    <label class="grid gap-2">
                                        <span class="text-sm font-semibold text-slate-200">Automatizable</span>
                                        <select name="steps[{{ $index }}][automatable]" class="rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-cyan-400">
                                            <option value="parcial" @selected(($step['automatable'] ?? 'parcial') === 'parcial')>Parcial</option>
                                            <option value="si" @selected(($step['automatable'] ?? '') === 'si')>Sí</option>
                                            <option value="no" @selected(($step['automatable'] ?? '') === 'no')>No</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div data-repeater="systems" class="mt-8 space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-lg font-semibold text-white">Sistemas involucrados</h3>
                        <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar sistema</button>
                    </div>
                    <div data-rows class="space-y-4">
                        @foreach ($systems as $index => $system)
                            <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-3">
                                <x-intake-input name="systems[{{ $index }}][name]" label="Nombre del sistema" value="{{ $system['name'] ?? '' }}" />
                                <x-intake-input name="systems[{{ $index }}][url]" label="URL" value="{{ $system['url'] ?? '' }}" />
                                <x-intake-input name="systems[{{ $index }}][system_type]" label="Tipo de sistema" value="{{ $system['system_type'] ?? '' }}" />
                                <x-intake-input name="systems[{{ $index }}][auth_type]" label="Tipo de autenticación" value="{{ $system['auth_type'] ?? '' }}" />
                                <x-intake-input name="systems[{{ $index }}][access_owner]" label="Responsable del acceso" value="{{ $system['access_owner'] ?? '' }}" />
                                <x-intake-input name="systems[{{ $index }}][access_status]" label="Estado del acceso" value="{{ $system['access_status'] ?? '' }}" placeholder="Pendiente, aprobado, bloqueado..." />
                                <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-900 px-4 py-3">
                                    <input type="checkbox" name="systems[{{ $index }}][has_api]" value="1" class="h-5 w-5 rounded border-white/20 bg-slate-900 accent-cyan-400" @checked(!empty($system['has_api']))>
                                    <span class="text-sm font-semibold text-slate-200">Tiene API</span>
                                </label>
                                <x-intake-input name="systems[{{ $index }}][notes]" label="Observaciones" value="{{ $system['notes'] ?? '' }}" wrapper-class="md:col-span-2" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-intake-section>
        @elseif ($section === 'documentos')
            @php
                $documents = old('documents', $process?->documents?->map(fn ($document) => [
                    'name' => $document->name,
                    'type' => $document->type,
                    'format' => $document->format,
                    'location' => $document->location,
                    'owner' => $document->owner,
                    'mandatory' => $document->mandatory,
                    'notes' => $document->notes,
                ])->values()->all() ?: [[]]);

                $problems = old('problems', $process?->problems?->map(fn ($problem) => [
                    'description' => $problem->description,
                    'impact' => $problem->impact,
                    'frequency' => $problem->frequency,
                    'risk' => $problem->risk,
                    'comments' => $problem->comments,
                ])->values()->all() ?: [[]]);
            @endphp
            <x-intake-section step="4" title="Evidencias y problemas" subtitle="Registra documentos, archivos, cuellos de botella y riesgos actuales.">
                <div data-repeater="documents" class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-lg font-semibold text-white">Documentos y evidencias</h3>
                        <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar documento</button>
                    </div>
                    <div data-rows class="space-y-4">
                        @foreach ($documents as $index => $document)
                            <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-3">
                                <x-intake-input name="documents[{{ $index }}][name]" label="Nombre" value="{{ $document['name'] ?? '' }}" />
                                <x-intake-input name="documents[{{ $index }}][type]" label="Tipo" value="{{ $document['type'] ?? '' }}" />
                                <x-intake-input name="documents[{{ $index }}][format]" label="Formato" value="{{ $document['format'] ?? '' }}" />
                                <x-intake-input name="documents[{{ $index }}][location]" label="Ubicación" value="{{ $document['location'] ?? '' }}" />
                                <x-intake-input name="documents[{{ $index }}][owner]" label="Responsable" value="{{ $document['owner'] ?? '' }}" />
                                <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-900 px-4 py-3">
                                    <input type="checkbox" name="documents[{{ $index }}][mandatory]" value="1" class="h-5 w-5 rounded border-white/20 bg-slate-900 accent-cyan-400" @checked(!empty($document['mandatory']))>
                                    <span class="text-sm font-semibold text-slate-200">Obligatorio</span>
                                </label>
                                <x-intake-textarea name="documents[{{ $index }}][notes]" label="Observaciones" value="{{ $document['notes'] ?? '' }}" wrapper-class="md:col-span-3" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div data-repeater="problems" class="mt-8 space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-lg font-semibold text-white">Problemas actuales</h3>
                        <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar problema</button>
                    </div>
                    <div data-rows class="space-y-4">
                        @foreach ($problems as $index => $problem)
                            <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-2">
                                <x-intake-textarea name="problems[{{ $index }}][description]" label="Descripción" value="{{ $problem['description'] ?? '' }}" />
                                <x-intake-textarea name="problems[{{ $index }}][comments]" label="Comentarios" value="{{ $problem['comments'] ?? '' }}" />
                                <x-intake-input name="problems[{{ $index }}][impact]" label="Impacto" value="{{ $problem['impact'] ?? '' }}" />
                                <x-intake-input name="problems[{{ $index }}][frequency]" label="Frecuencia" value="{{ $problem['frequency'] ?? '' }}" />
                                <x-intake-input name="problems[{{ $index }}][risk]" label="Riesgo" value="{{ $problem['risk'] ?? '' }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-intake-section>
        @elseif ($section === 'automatizacion')
            @php
                $opportunities = old('opportunities', $process?->opportunities?->map(fn ($item) => [
                    'activity' => $item->activity,
                    'current_time_minutes' => $item->current_time_minutes,
                    'expected_time_minutes' => $item->expected_time_minutes,
                    'suggested_technology' => $item->suggested_technology,
                    'priority' => $item->priority,
                    'complexity' => $item->complexity,
                    'notes' => $item->notes,
                ])->values()->all() ?: [[]]);
                $evaluation = old('evaluation', $process?->evaluations?->first()?->toArray() ?? []);
            @endphp
            <x-intake-section step="5" title="Automatización y evaluación" subtitle="Prioriza oportunidades y captura criterios técnicos internos.">
                <div data-repeater="opportunities" class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-lg font-semibold text-white">Oportunidades de automatización</h3>
                        <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar oportunidad</button>
                    </div>
                    <div data-rows class="space-y-4">
                        @foreach ($opportunities as $index => $item)
                            <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-3">
                                <x-intake-input name="opportunities[{{ $index }}][activity]" label="Actividad" value="{{ $item['activity'] ?? '' }}" wrapper-class="md:col-span-3" />
                                <x-intake-input name="opportunities[{{ $index }}][current_time_minutes]" label="Tiempo actual min." type="number" value="{{ $item['current_time_minutes'] ?? '' }}" />
                                <x-intake-input name="opportunities[{{ $index }}][expected_time_minutes]" label="Tiempo esperado min." type="number" value="{{ $item['expected_time_minutes'] ?? '' }}" />
                                <x-intake-input name="opportunities[{{ $index }}][suggested_technology]" label="Tecnología sugerida" value="{{ $item['suggested_technology'] ?? '' }}" placeholder="Hermes Agent, MCP, n8n, IA, RPA, API, OCR" />
                                <x-intake-input name="opportunities[{{ $index }}][priority]" label="Prioridad" value="{{ $item['priority'] ?? '' }}" placeholder="Alta, media, baja" />
                                <x-intake-input name="opportunities[{{ $index }}][complexity]" label="Complejidad 1-5" type="number" value="{{ $item['complexity'] ?? '' }}" />
                                <x-intake-input name="opportunities[{{ $index }}][notes]" label="Notas" value="{{ $item['notes'] ?? '' }}" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-5">
                    <h3 class="text-lg font-semibold text-white">Evaluación interna</h3>
                    <div class="mt-4 grid gap-4 md:grid-cols-4">
                        <x-intake-input name="evaluation[complexity]" label="Complejidad 1-5" type="number" value="{{ old('evaluation.complexity', $evaluation['complexity'] ?? '') }}" />
                        <x-intake-input name="evaluation[risk]" label="Riesgo 1-5" type="number" value="{{ old('evaluation.risk', $evaluation['risk'] ?? '') }}" />
                        <x-intake-input name="evaluation[impact]" label="Impacto 1-5" type="number" value="{{ old('evaluation.impact', $evaluation['impact'] ?? '') }}" />
                        <x-intake-input name="evaluation[estimated_hours]" label="Horas estimadas" type="number" value="{{ old('evaluation.estimated_hours', $evaluation['estimated_hours'] ?? '') }}" />
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
                                <input type="checkbox" name="evaluation[{{ $name }}]" value="1" class="h-5 w-5 rounded border-white/20 bg-slate-900 accent-cyan-400" @checked(old('evaluation.'.$name, !empty($evaluation[$name] ?? false)))>
                                <span class="text-sm font-semibold text-slate-200">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <x-intake-textarea name="evaluation[technical_notes]" label="Observaciones técnicas" value="{{ old('evaluation.technical_notes', $evaluation['technical_notes'] ?? '') }}" />
                    </div>
                </div>
            </x-intake-section>
        @elseif ($section === 'tareas')
            @php
                $backlog = old('backlog', $process?->backlogItems?->map(fn ($item) => [
                    'type' => $item->type,
                    'title' => $item->title,
                    'description' => $item->description,
                    'acceptance_criteria' => $item->acceptance_criteria,
                    'priority' => $item->priority,
                    'responsible' => $item->responsible,
                    'estimated_hours' => $item->estimated_hours,
                ])->values()->all() ?: [[]]);
            @endphp
            <x-intake-section step="6" title="Tareas iniciales" subtitle="Convierte el levantamiento en trabajo accionable.">
                <div data-repeater="backlog" class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-lg font-semibold text-white">Tareas sugeridas</h3>
                        <button type="button" data-add-row class="rounded-full border border-cyan-300/30 px-4 py-2 text-sm font-semibold text-cyan-100 hover:bg-cyan-400/10">Agregar tarea</button>
                    </div>
                    <div data-rows class="space-y-4">
                        @foreach ($backlog as $index => $item)
                            <div data-row class="grid gap-4 rounded-3xl border border-white/10 bg-white/5 p-5 md:grid-cols-3">
                                <x-intake-input name="backlog[{{ $index }}][type]" label="Tipo" value="{{ $item['type'] ?? '' }}" placeholder="Historia, tarea técnica, integración..." />
                                <x-intake-input name="backlog[{{ $index }}][title]" label="Título" value="{{ $item['title'] ?? '' }}" wrapper-class="md:col-span-2" />
                                <x-intake-textarea name="backlog[{{ $index }}][description]" label="Descripción" value="{{ $item['description'] ?? '' }}" />
                                <x-intake-textarea name="backlog[{{ $index }}][acceptance_criteria]" label="Criterios de aceptación" value="{{ $item['acceptance_criteria'] ?? '' }}" />
                                <div class="grid gap-4">
                                    <x-intake-input name="backlog[{{ $index }}][priority]" label="Prioridad" value="{{ $item['priority'] ?? '' }}" />
                                    <x-intake-input name="backlog[{{ $index }}][responsible]" label="Responsable" value="{{ $item['responsible'] ?? '' }}" />
                                    <x-intake-input name="backlog[{{ $index }}][estimated_hours]" label="Horas estimadas" type="number" value="{{ $item['estimated_hours'] ?? '' }}" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-intake-section>
        @endif

        <div class="flex flex-col gap-3 rounded-3xl border border-cyan-400/20 bg-cyan-500/10 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-cyan-200">Acciones</p>
                <p class="mt-1 text-xl font-semibold text-white">
                    @if ($next)
                        Continuar al siguiente paso
                    @else
                        Guardar ficha de proceso
                    @endif
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                @if ($previous)
                    <a href="{{ route('consulting-intake.section', ['section' => $previous, 'ruc' => $client?->ruc]) }}" class="rounded-2xl border border-white/10 bg-white/5 px-6 py-4 font-semibold text-white">
                        Volver
                    </a>
                @endif
                <button type="submit" class="rounded-2xl bg-gradient-to-r from-cyan-400 to-blue-500 px-6 py-4 font-bold text-slate-950 shadow-xl shadow-cyan-950/30 hover:from-cyan-300 hover:to-blue-400">
                    @if ($next)
                        Guardar y continuar
                    @else
                        Guardar y finalizar
                    @endif
                </button>
            </div>
        </div>
    </form>
</div>

@if (in_array($section, ['cliente', 'as-is', 'documentos', 'automatizacion', 'tareas'], true))
<script>
    const leadPicker = document.querySelector('[data-lead-picker]');
    if (leadPicker) {
        leadPicker.addEventListener('change', (event) => {
            const leadId = event.target.value;
            const currentUrl = new URL(window.location.href);

            if (leadId) {
                currentUrl.searchParams.set('lead', leadId);
            } else {
                currentUrl.searchParams.delete('lead');
            }

            window.location.href = currentUrl.toString();
        });
    }

    document.querySelectorAll('[data-repeater]').forEach((repeater) => {
        const rows = repeater.querySelector('[data-rows]');
        const firstRow = rows.querySelector('[data-row]');
        const button = repeater.querySelector('[data-add-row]');

        if (!firstRow || !button) {
            return;
        }

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
@endif
@endsection
