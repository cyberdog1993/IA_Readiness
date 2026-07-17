<?php

namespace App\Services;

use App\Models\ProcessAssumption;
use App\Models\ProcessConstraint;
use App\Models\ProcessDecision;
use App\Models\ProcessDependency;
use App\Models\ProcessException;
use App\Models\ProcessMetric;
use App\Models\ProcessModel;
use App\Models\ProcessStakeholder;

class ProcessExportService
{
    public function toArray(ProcessModel $process): array
    {
        $process = $this->loadGraph($process);

        return [
            'lead' => [
                'company_name' => $process->client?->lead?->company_name,
                'ruc' => $process->client?->lead?->ruc,
                'industry' => $process->client?->lead?->industry,
                'maturity_score' => $process->client?->lead?->maturity_score,
                'maturity_level' => $process->client?->lead?->maturity_level,
                'version' => $process->client?->lead?->version,
                'consultant_name' => $process->client?->lead?->consultant_name,
                'source' => $process->client?->lead?->source,
            ],
            'client' => [
                'business_name' => $process->client?->business_name,
                'ruc' => $process->client?->ruc,
                'industry' => $process->client?->industry,
                'contact_name' => $process->client?->main_contact,
                'contact_role' => $process->client?->contact_role,
                'email' => $process->client?->email,
                'phone' => $process->client?->phone,
            ],
            'process' => [
                'name' => $process->name,
                'area' => $process->area,
                'owner' => $process->owner,
                'frequency' => $process->frequency,
                'objective' => $process->objective,
                'expected_result' => $process->expected_result,
                'trigger_event' => $process->trigger_event,
                'validation_method' => $process->validation_method,
                'status' => $process->status,
                'version' => $process->version,
                'state' => $process->state,
                'consultant_name' => $process->consultant_name,
                'validated_at' => $process->validated_at?->toIso8601String(),
                'last_exported_at' => $process->last_exported_at?->toIso8601String(),
                'priority' => $process->priority,
                'secondary_objectives' => $process->secondary_objectives,
                'business_problems' => $process->business_problems,
                'completion_criteria' => $process->completion_criteria,
                'start_event' => $process->start_event,
                'end_event' => $process->end_event,
                'frequency_number' => $process->frequency_number,
                'frequency_period' => $process->frequency_period,
                'context_for_ai' => $process->context_for_ai,
                'category' => $process->category,
                'sector' => $process->sector,
                'tags' => $process->tags,
                'notes' => $process->notes,
            ],
            'stakeholders' => $process->stakeholders->map(fn (ProcessStakeholder $item) => $item->only([
                'name',
                'position',
                'area',
                'role',
                'participation_type',
                'email',
                'phone',
                'notes',
            ]))->values(),
            'dependencies' => $process->dependencies->map(fn (ProcessDependency $item) => [
                'type' => $item->type,
                'condition' => $item->condition,
                'notes' => $item->notes,
                'predecessor_step' => $item->predecessorStep?->only(['step_number', 'title', 'description']),
                'successor_step' => $item->successorStep?->only(['step_number', 'title', 'description']),
            ])->values(),
            'decisions' => $process->decisions->map(fn (ProcessDecision $item) => [
                'condition_evaluated' => $item->condition_evaluated,
                'decision_owner' => $item->decision_owner,
                'true_result' => $item->true_result,
                'false_result' => $item->false_result,
                'evidence' => $item->evidence,
                'step' => $item->step?->only(['step_number', 'title', 'description']),
            ])->values(),
            'exceptions' => $process->exceptions->map(fn (ProcessException $item) => [
                'trigger' => $item->trigger,
                'current_action' => $item->current_action,
                'owner' => $item->owner,
                'resolution_time_minutes' => $item->resolution_time_minutes,
                'severity' => $item->severity,
                'retry_possible' => $item->retry_possible,
                'escalation_rule' => $item->escalation_rule,
                'step' => $item->step?->only(['step_number', 'title', 'description']),
                'system' => $item->systemIntegration?->only(['name', 'system_type', 'url']),
            ])->values(),
            'metrics' => $process->metrics->map(fn (ProcessMetric $item) => $item->only([
                'name',
                'min_quantity',
                'avg_quantity',
                'max_quantity',
                'unit',
                'period',
                'source',
                'confirmed',
            ]))->values(),
            'constraints' => $process->constraints->map(fn (ProcessConstraint $item) => $item->only([
                'type',
                'description',
                'impact',
                'validation_owner',
                'status',
            ]))->values(),
            'assumptions' => $process->assumptions->map(fn (ProcessAssumption $item) => $item->only([
                'description',
                'impact',
                'validation_owner',
                'status',
            ]))->values(),
            'as_is' => $process->steps->map(fn ($step) => $step->only([
                'title',
                'step_number',
                'description',
                'owner',
                'system_used',
                'input',
                'output',
                'estimated_minutes',
                'min_minutes',
                'avg_minutes',
                'max_minutes',
                'wait_minutes',
                'frequency_volume',
                'execution_type',
                'requires_human_validation',
                'sequence_type',
                'evidence_generated',
                'problems',
                'automatable',
                'comments',
            ]))->values(),
            'systems' => $process->systems->map(fn ($system) => $system->only([
                'name',
                'url',
                'system_type',
                'description',
                'has_api',
                'api_available',
                'api_type',
                'api_version',
                'documentation_url',
                'webhooks_available',
                'known_limits',
                'environment',
                'auth_type',
                'access_owner',
                'access_status',
                'access_status_detail',
                'restrictions',
                'notes',
            ]))->values(),
            'documents' => $process->documents->map(fn ($document) => $document->only([
                'name',
                'type',
                'format',
                'location',
                'owner',
                'mandatory',
                'direction',
                'sensitivity',
                'retention',
                'schema_summary',
                'example_reference',
                'notes',
            ]))->values(),
            'problems' => $process->problems->map(fn ($problem) => $problem->only([
                'description',
                'trigger',
                'current_action',
                'resolution_time_minutes',
                'impact',
                'frequency',
                'risk',
                'severity',
                'retry_possible',
                'escalation_rule',
                'comments',
            ]))->values(),
            'opportunities' => $process->opportunities->map(fn ($item) => $item->only([
                'activity',
                'problem',
                'current_time_minutes',
                'current_time_period',
                'expected_time_minutes',
                'expected_time_period',
                'estimated_savings_minutes',
                'execution_volume',
                'monthly_savings_minutes',
                'annual_savings_minutes',
                'automation_percentage',
                'human_validation_required',
                'confidence',
                'suggested_technology',
                'technologies',
                'dependencies',
                'priority',
                'complexity',
                'status',
                'notes',
            ]))->values(),
            'internal_evaluation' => $process->evaluations->map(fn ($item) => $item->only([
                'complexity',
                'risk',
                'impact',
                'confidence',
                'requires_mcp',
                'requires_hermes_skill',
                'requires_n8n',
                'requires_ai',
                'requires_ocr',
                'estimated_hours',
                'integrations_required',
                'security_requirements',
                'hours_phase_1',
                'hours_phase_2',
                'hours_phase_3',
                'responsible',
                'review_state',
                'candidate_technologies',
                'dependencies',
                'technical_notes',
            ]))->values(),
            'backlog' => $process->backlogItems->map(fn ($item) => $item->only([
                'epic',
                'type',
                'title',
                'description',
                'acceptance_criteria',
                'priority',
                'responsible',
                'status',
                'estimated_hours',
                'dependencies',
                'origin',
                'phase',
                'due_date',
            ]))->values(),
            'automation_prompt' => $this->automationPrompt($process),
        ];
    }

    public function toMarkdown(ProcessModel $process): string
    {
        $process = $this->loadGraph($process);

        $lines = [];
        $lines[] = '# Diagnóstico de Automatización - '.($process->client?->business_name);
        $lines[] = '';
        $lines[] = '## Cliente';
        $lines[] = '- Razón social: '.($process->client?->business_name);
        $lines[] = '- RUC: '.($process->client?->ruc);
        $lines[] = '- Rubro: '.($process->client?->industry);
        $lines[] = '- Contacto: '.$process->client?->main_contact;
        $lines[] = '- Correo: '.$process->client?->email;
        $lines[] = '- Teléfono: '.$process->client?->phone;
        $lines[] = '';
        $lines[] = '## Proceso';
        $lines[] = '- Nombre: '.$process->name;
        $lines[] = '- Área: '.($process->area ?: '-');
        $lines[] = '- Responsable: '.($process->owner ?: '-');
        $lines[] = '- Frecuencia: '.($process->frequency ?: '-');
        $lines[] = '- Objetivo: '.($process->objective ?: '-');
        $lines[] = '- Resultado esperado: '.($process->expected_result ?: '-');
        $lines[] = '- Evento que inicia: '.($process->trigger_event ?: '-');
        $lines[] = '- Validación de término: '.($process->validation_method ?: '-');
        $lines[] = '- Versión: '.($process->version ?: 1);
        $lines[] = '- Estado: '.($process->state ?: '-');
        $lines[] = '- Prioridad: '.($process->priority ?: '-');
        $lines[] = '- Categoría: '.($process->category ?: '-');
        $lines[] = '- Sector: '.($process->sector ?: '-');
        $lines[] = '- Contexto IA: '.($process->context_for_ai ?: '-');
        $lines[] = '';
        $lines[] = '## Sistemas involucrados';
        if ($process->systems->isEmpty()) {
            $lines[] = '- Pendiente de registrar sistemas.';
        } else {
            foreach ($process->systems as $system) {
                $lines[] = '- '.$system->name.' ('.$system->system_type.')';
                $lines[] = '  - API: '.($system->has_api ? 'Sí' : 'No').', Webhooks: '.($system->webhooks_available ? 'Sí' : 'No').', Autenticación: '.($system->auth_type ?: '-');
            }
        }
        $lines[] = '';
        $lines[] = '## Actores y responsables';
        if ($process->stakeholders->isEmpty()) {
            $lines[] = '- Pendiente de registrar stakeholders.';
        } else {
            foreach ($process->stakeholders as $stakeholder) {
                $lines[] = '- '.$stakeholder->name.' / '.($stakeholder->role ?: '-').' / '.($stakeholder->area ?: '-');
            }
        }
        $lines[] = '';
        $lines[] = '## AS-IS';
        $lines[] = '| Paso | Título | Descripción | Responsable | Sistema | Entrada | Salida | Min | Evidencia | Problemas | Automatizable |';
        $lines[] = '|---|---|---|---|---|---|---|---:|---|---|---|';
        foreach ($process->steps as $step) {
            $lines[] = '| '.$step->step_number.' | '.($step->title ?: '-').' | '.$step->description.' | '.$step->owner.' | '.$step->system_used.' | '.$step->input.' | '.$step->output.' | '.$step->estimated_minutes.' | '.$step->evidence_generated.' | '.$step->problems.' | '.$step->automatable.' |';
        }
        $lines[] = '';
        $lines[] = '## Problemas actuales';
        if ($process->problems->isEmpty()) {
            $lines[] = '- Pendiente de registrar problemas.';
        } else {
            foreach ($process->problems as $problem) {
                $lines[] = '- '.$problem->description.' ('.$problem->impact.')';
                $lines[] = '  - Disparador: '.($problem->trigger ?: '-').', Acción actual: '.($problem->current_action ?: '-').', Severidad: '.($problem->severity ?: '-');
            }
        }
        $lines[] = '';
        $lines[] = '## Excepciones';
        if ($process->exceptions->isEmpty()) {
            $lines[] = '- Pendiente de registrar excepciones.';
        } else {
            foreach ($process->exceptions as $exception) {
                $lines[] = '- '.($exception->trigger ?: 'Excepción').' / '.($exception->owner ?: '-').' / '.($exception->severity ?: '-');
            }
        }
        $lines[] = '';
        $lines[] = '## Decisiones';
        if ($process->decisions->isEmpty()) {
            $lines[] = '- Pendiente de registrar decisiones.';
        } else {
            foreach ($process->decisions as $decision) {
                $lines[] = '- '.($decision->condition_evaluated ?: 'Condición sin definir').' / '.($decision->decision_owner ?: '-');
            }
        }
        $lines[] = '';
        $lines[] = '## Métricas';
        if ($process->metrics->isEmpty()) {
            $lines[] = '- Pendiente de registrar métricas.';
        } else {
            foreach ($process->metrics as $metric) {
                $lines[] = '- '.$metric->name.' / '.($metric->avg_quantity ?? '-').' '.($metric->unit ?: '').' / '.($metric->period ?: '-');
            }
        }
        $lines[] = '';
        $lines[] = '## Restricciones y supuestos';
        if ($process->constraints->isEmpty()) {
            $lines[] = '- Pendiente de registrar restricciones.';
        } else {
            foreach ($process->constraints as $constraint) {
                $lines[] = '- Restricción: '.$constraint->description.' ('.$constraint->type.')';
            }
        }
        if ($process->assumptions->isEmpty()) {
            $lines[] = '- Pendiente de registrar supuestos.';
        } else {
            foreach ($process->assumptions as $assumption) {
                $lines[] = '- Supuesto: '.$assumption->description;
            }
        }
        $lines[] = '';
        $lines[] = '## Documentos y evidencias';
        if ($process->documents->isEmpty()) {
            $lines[] = '- Pendiente de registrar documentos.';
        } else {
            foreach ($process->documents as $document) {
                $lines[] = '- '.$document->name.' / '.$document->type.' / '.$document->format.' / '.($document->direction ?: '-');
            }
        }
        $lines[] = '';
        $lines[] = '## Oportunidades de automatización';
        if ($process->opportunities->isEmpty()) {
            $lines[] = '- Pendiente de consolidar oportunidades.';
        } else {
            foreach ($process->opportunities as $item) {
                $lines[] = '- '.$item->activity.' / '.$item->suggested_technology.' / '.$item->priority.' / ahorro: '.($item->estimated_savings_minutes ?? 0).' min';
            }
        }
        $lines[] = '';
        $lines[] = '## Evaluación interna';
        if ($process->evaluations->isEmpty()) {
            $lines[] = '- Pendiente de evaluación técnica.';
        } else {
            foreach ($process->evaluations as $item) {
                $lines[] = '- Complejidad: '.$item->complexity.' | Riesgo: '.$item->risk.' | Impacto: '.$item->impact.' | Horas: '.$item->estimated_hours.' | Confianza: '.($item->confidence ?: '-');
            }
        }
        $lines[] = '';
        $lines[] = '## Backlog sugerido';
        if ($process->backlogItems->isEmpty()) {
            $lines[] = '- Pendiente de backlog.';
        } else {
            foreach ($process->backlogItems as $item) {
                $lines[] = '- ['.$item->priority.'] '.$item->title.' ('.$item->type.')';
            }
        }
        $lines[] = '';
        $lines[] = '## Trazabilidad';
        $lines[] = '- Consultor: '.($process->consultant_name ?: '-');
        $lines[] = '- Validado en: '.($process->validated_at?->format('d/m/Y H:i') ?? '-');
        $lines[] = '- Exportado en: '.($process->last_exported_at?->format('d/m/Y H:i') ?? '-');
        $lines[] = '- Tags: '.(is_array($process->tags) && $process->tags !== [] ? implode(', ', $process->tags) : '-');
        $lines[] = '';
        $lines[] = '## Recomendación técnica';
        $lines[] = $this->automationPrompt($process);

        return implode("\n", $lines);
    }

    public function automationPrompt(ProcessModel $process): string
    {
        return 'Resume el proceso '.$process->name.' de '.($process->client?->business_name).', identifica stakeholders, decisiones, excepciones, métricas, restricciones, oportunidades, riesgos, ROI estimado, roadmap y una propuesta preliminar lista para ChatGPT, Claude y Hermes Agent.';
    }

    public function toPdfLines(ProcessModel $process): array
    {
        $process = $this->loadGraph($process);

        $lines = [
            'Cliente: '.($process->client?->business_name),
            'Proceso: '.$process->name,
            'Área: '.($process->area ?: '-'),
            'Responsable: '.($process->owner ?: '-'),
            'Frecuencia: '.($process->frequency ?: '-'),
            'Versión: '.($process->version ?: 1),
            'Estado: '.($process->state ?: '-'),
            '',
            'Objetivo',
            $process->objective ?: '-',
            '',
            'Resultado esperado',
            $process->expected_result ?: '-',
            '',
            'Sistemas involucrados',
        ];

        foreach ($process->systems as $system) {
            $lines[] = '- '.$system->name.' ('.$system->system_type.')';
        }

        $lines[] = '';
        $lines[] = 'Stakeholders';
        foreach ($process->stakeholders as $stakeholder) {
            $lines[] = '- '.$stakeholder->name.' / '.($stakeholder->role ?: '-');
        }

        $lines[] = '';
        $lines[] = 'AS-IS';
        foreach ($process->steps as $step) {
            $lines[] = 'Paso '.$step->step_number.': '.($step->title ?: $step->description).' | '.$step->owner.' | '.$step->system_used.' | '.$step->automatable;
        }

        $lines[] = '';
        $lines[] = 'Problemas actuales';
        foreach ($process->problems as $problem) {
            $lines[] = '- '.$problem->description.' ('.$problem->impact.')';
        }

        $lines[] = '';
        $lines[] = 'Excepciones';
        foreach ($process->exceptions as $exception) {
            $lines[] = '- '.($exception->trigger ?: '-').' / '.($exception->owner ?: '-').' / '.($exception->severity ?: '-');
        }

        $lines[] = '';
        $lines[] = 'Métricas';
        foreach ($process->metrics as $metric) {
            $lines[] = '- '.$metric->name.' / '.($metric->avg_quantity ?? '-').' '.($metric->unit ?: '').' / '.($metric->period ?: '-');
        }

        $lines[] = '';
        $lines[] = 'Documentos y evidencias';
        foreach ($process->documents as $document) {
            $lines[] = '- '.$document->name.' / '.$document->type.' / '.$document->format;
        }

        $lines[] = '';
        $lines[] = 'Oportunidades de automatización';
        foreach ($process->opportunities as $item) {
            $lines[] = '- '.$item->activity.' / '.$item->suggested_technology.' / '.$item->priority;
        }

        $lines[] = '';
        $lines[] = 'Evaluación interna';
        foreach ($process->evaluations as $item) {
            $lines[] = '- Complejidad '.$item->complexity.' | Riesgo '.$item->risk.' | Impacto '.$item->impact.' | Horas '.$item->estimated_hours;
        }

        $lines[] = '';
        $lines[] = 'Backlog sugerido';
        foreach ($process->backlogItems as $item) {
            $lines[] = '- ['.$item->priority.'] '.$item->title.' ('.$item->type.')';
        }

        $lines[] = '';
        $lines[] = 'Prompt para ChatGPT';
        $lines[] = $this->automationPrompt($process);

        return $lines;
    }

    private function loadGraph(ProcessModel $process): ProcessModel
    {
        return $process->loadMissing([
            'client.lead',
            'creator',
            'updater',
            'templateProcess',
            'steps',
            'systems',
            'documents',
            'problems',
            'opportunities',
            'evaluations',
            'backlogItems',
            'stakeholders',
            'dependencies.predecessorStep',
            'dependencies.successorStep',
            'decisions.step',
            'exceptions.step',
            'exceptions.systemIntegration',
            'metrics',
            'constraints',
            'assumptions',
        ]);
    }
}
