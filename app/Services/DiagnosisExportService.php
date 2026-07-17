<?php

namespace App\Services;

use App\Exports\DiagnosisWorkbookExport;
use App\Models\Lead;
use App\Models\ProcessAssumption;
use App\Models\ProcessConstraint;
use App\Models\ProcessDecision;
use App\Models\ProcessDependency;
use App\Models\ProcessException;
use App\Models\ProcessMetric;
use App\Models\ProcessModel;
use App\Models\ProcessStakeholder;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DiagnosisExportService
{
    public function __construct(private readonly SimplePdfWriter $pdfWriter)
    {
    }

    public function toArray(Lead $lead): array
    {
        $lead = $this->loadGraph($lead);

        return [
            'client' => [
                'company_name' => $lead->company_name,
                'ruc' => $lead->ruc,
                'industry' => $lead->industry,
                'report_date' => $lead->reportDateLabel(),
                'contact_name' => $lead->contact_name,
                'contact_role' => $lead->contact_role,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'maturity_score' => $lead->maturity_score,
                'maturity_level' => $lead->maturity_level,
                'version' => $lead->version,
                'consultant_name' => $lead->consultant_name,
                'source' => $lead->source,
                'annual_current_hours' => $lead->annualCurrentHours(),
                'annual_potential_hours' => $lead->annualPotentialHours(),
                'annual_savings_hours' => $lead->annualSavingsHours(),
                'diagnosis_brief' => $lead->diagnosis_brief,
                'opportunities_summary' => $lead->opportunities_summary,
                'recommendation' => $lead->recommendation,
                'lead_score_label' => $lead->leadScoreLabel(),
                'next_step' => $lead->nextStepRecommendation(),
                'strengths' => $lead->strengthsSummary(),
                'risks' => $lead->risksSummary(),
            ],
            'processes' => $lead->processes->map(fn (ProcessModel $process) => $this->serializeProcess($process))->values(),
            'systems' => $lead->processes->flatMap(fn ($process) => $process->systems->map(fn ($system) => $system->only([
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
            ])))->values(),
            'opportunities' => $lead->processes->flatMap(fn ($process) => $process->opportunities->map(fn ($item) => $item->only([
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
            ])))->values(),
            'evaluations' => $lead->processes->flatMap(fn ($process) => $process->evaluations->map(fn ($item) => $item->only([
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
            ])))->values(),
            'backlog' => $lead->processes->flatMap(fn ($process) => $process->backlogItems->map(fn ($item) => $item->only([
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
            ])))->values(),
            'automation_payload' => $this->toAutomationPayload($lead),
        ];
    }

    public function toMarkdown(Lead $lead): string
    {
        $lead = $this->loadGraph($lead);
        $process = $lead->processes->first();

        $markdown = [];
        $markdown[] = '# Diagnóstico de Automatización - '.$lead->company_name;
        $markdown[] = '';
        $markdown[] = '## Cliente';
        $markdown[] = '- Razón social: '.$lead->company_name;
        $markdown[] = '- RUC: '.$lead->ruc;
        $markdown[] = '- Rubro: '.$lead->industry;
        $markdown[] = '- Contacto: '.$lead->contact_name.' / '.$lead->contact_role;
        $markdown[] = '- Correo: '.$lead->email;
        $markdown[] = '- Teléfono: '.$lead->phone;
        $markdown[] = '- Nota de madurez: '.$lead->maturity_score.'/100';
        $markdown[] = '- Nivel: '.$lead->maturity_level;
        $markdown[] = '- Horas actuales al año: '.$lead->annualCurrentHours();
        $markdown[] = '- Horas potenciales con automatización: '.$lead->annualPotentialHours();
        $markdown[] = '- Ahorro estimado anual: '.$lead->annualSavingsHours();
        $markdown[] = '';
        $markdown[] = '## Proceso';
        $markdown[] = '- Proceso principal: '.($process?->name ?? 'Pendiente de levantar');
        $markdown[] = '- Área: '.($process?->area ?? '-');
        $markdown[] = '- Responsable: '.($process?->owner ?? '-');
        $markdown[] = '- Estado: '.($process?->state ?? '-');
        $markdown[] = '- Versión: '.($process?->version ?? 1);
        $markdown[] = '- Prioridad: '.($process?->priority ?? '-');
        $markdown[] = '- Contexto IA: '.($process?->context_for_ai ?? '-');
        $markdown[] = '';
        $markdown[] = '## Objetivo';
        $markdown[] = $process?->objective ?? 'Pendiente de definición';
        $markdown[] = '';
        $markdown[] = '## Sistemas involucrados';
        $hasSystems = false;
        foreach ($lead->processes as $item) {
            foreach ($item->systems as $system) {
                $hasSystems = true;
                $markdown[] = '- '.$item->name.' / '.$system->name.' ('.$system->system_type.')';
            }
        }
        if (!$hasSystems) {
            $markdown[] = '- Pendiente de registrar sistemas.';
        }
        $markdown[] = '';
        $markdown[] = '## Actores y trazabilidad';
        $hasStakeholders = false;
        foreach ($lead->processes as $item) {
            foreach ($item->stakeholders as $stakeholder) {
                $hasStakeholders = true;
                $markdown[] = '- '.$item->name.' / '.$stakeholder->name.' / '.($stakeholder->role ?: '-');
            }
        }
        if (!$hasStakeholders) {
            $markdown[] = '- Pendiente de registrar stakeholders.';
        }
        $markdown[] = '';
        $markdown[] = '## AS-IS';
        $markdown[] = '| Proceso | Paso | Título | Descripción | Responsable | Sistema | Entrada | Salida | Min | Evidencia | Problemas | Automatizable |';
        $markdown[] = '|---|---|---|---|---|---|---|---|---:|---|---|---|';
        foreach ($lead->processes as $item) {
            foreach ($item->steps as $step) {
                $markdown[] = '| '.$item->name.' | '.$step->step_number.' | '.($step->title ?: '-').' | '.$step->description.' | '.$step->owner.' | '.$step->system_used.' | '.$step->input.' | '.$step->output.' | '.$step->estimated_minutes.' | '.$step->evidence_generated.' | '.$step->problems.' | '.$step->automatable.' |';
            }
        }
        $markdown[] = '';
        $markdown[] = '## Problemas actuales';
        $markdown[] = $lead->processes()->with('problems')->get()->flatMap(fn ($item) => $item->problems->map(fn ($problem) => '- '.$item->name.' / '.$problem->description.' / '.($problem->impact ?: '-')))->implode("\n") ?: '- Pendiente de registrar problemas.';
        $markdown[] = '';
        $markdown[] = '## Excepciones';
        $markdown[] = $lead->processes()->with('exceptions')->get()->flatMap(fn ($item) => $item->exceptions->map(fn ($exception) => '- '.$item->name.' / '.($exception->trigger ?: '-').' / '.($exception->severity ?: '-')))->implode("\n") ?: '- Pendiente de registrar excepciones.';
        $markdown[] = '';
        $markdown[] = '## Métricas';
        $markdown[] = $lead->processes()->with('metrics')->get()->flatMap(fn ($item) => $item->metrics->map(fn ($metric) => '- '.$item->name.' / '.$metric->name.' / '.($metric->avg_quantity ?? '-').' '.($metric->unit ?: '')))->implode("\n") ?: '- Pendiente de registrar métricas.';
        $markdown[] = '';
        $markdown[] = '## Restricciones y supuestos';
        $markdown[] = $lead->processes()->with('constraints')->get()->flatMap(fn ($item) => $item->constraints->map(fn ($constraint) => '- '.$item->name.' / '.$constraint->description.' / '.($constraint->status ?: '-')))->implode("\n") ?: '- Pendiente de registrar restricciones.';
        $markdown[] = $lead->processes()->with('assumptions')->get()->flatMap(fn ($item) => $item->assumptions->map(fn ($assumption) => '- '.$item->name.' / '.$assumption->description.' / '.($assumption->status ?: '-')))->implode("\n") ?: '- Pendiente de registrar supuestos.';
        $markdown[] = '';
        $markdown[] = '## Oportunidades de automatización';
        $markdown[] = $lead->opportunities_summary ?: '- Pendiente de consolidar oportunidades.';
        $markdown[] = '';
        $markdown[] = '## Evaluación interna';
        if ($process && $process->evaluations->isNotEmpty()) {
            foreach ($process->evaluations as $evaluation) {
                $markdown[] = '- Complejidad: '.$evaluation->complexity.' | Riesgo: '.$evaluation->risk.' | Impacto: '.$evaluation->impact.' | Horas: '.$evaluation->estimated_hours;
                $markdown[] = '  - MCP: '.($evaluation->requires_mcp ? 'Sí' : 'No').', Hermes: '.($evaluation->requires_hermes_skill ? 'Sí' : 'No').', n8n: '.($evaluation->requires_n8n ? 'Sí' : 'No').', IA: '.($evaluation->requires_ai ? 'Sí' : 'No').', OCR: '.($evaluation->requires_ocr ? 'Sí' : 'No');
            }
        } else {
            $markdown[] = '- Requiere MCP: Sí/No según evaluación técnica.';
            $markdown[] = '- Requiere Skill Hermes: Sí/No según evaluación técnica.';
        }
        $markdown[] = '';
        $markdown[] = '## Tareas sugeridas';
        if ($process && $process->backlogItems->isNotEmpty()) {
            foreach ($process->backlogItems as $item) {
                $markdown[] = '- ['.$item->priority.'] '.$item->title.' ('.$item->type.')';
                $markdown[] = '  - '.$item->description;
            }
        } else {
            $markdown[] = '- Definir historias, integraciones y validaciones.';
        }
        $markdown[] = '';
        $markdown[] = '## Recomendación técnica';
        $markdown[] = $lead->recommendation ?: 'Iniciar con diagnóstico y priorización.';
        $markdown[] = '';
        $markdown[] = '## Datos para propuesta';
        $markdown[] = '- Madurez: '.$lead->maturity_score.'/100';
        $markdown[] = '- Nivel: '.$lead->maturity_level;
        $markdown[] = '- Lead scoring: '.$lead->leadScoreLabel();
        $markdown[] = '- Próximo paso: '.$lead->nextStepRecommendation();

        return implode("\n", $markdown);
    }

    public function downloadExcel(Lead $lead): BinaryFileResponse
    {
        return Excel::download(new DiagnosisWorkbookExport($lead), 'diagnostico-'.$lead->ruc.'.xlsx');
    }

    public function downloadClientPdf(Lead $lead): BinaryFileResponse
    {
        $lead = $this->loadGraph($lead);

        return $this->pdfWriter->download(
            'diagnostico-cliente-'.$lead->ruc.'.pdf',
            'Informe del cliente - '.$lead->company_name,
            $this->clientPdfLines($lead)
        );
    }

    public function downloadInternalPdf(Lead $lead): BinaryFileResponse
    {
        $lead = $this->loadGraph($lead);

        return $this->pdfWriter->download(
            'diagnostico-interno-'.$lead->ruc.'.pdf',
            'Informe interno - '.$lead->company_name,
            $this->internalPdfLines($lead)
        );
    }

    public function downloadWord(Lead $lead): BinaryFileResponse
    {
        $lead = $this->loadGraph($lead);
        $path = storage_path('app/diagnostico-'.$lead->ruc.'.docx');

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addTitle('Diagnóstico de Automatización - '.$lead->company_name, 1);
        $section->addText('Resumen ejecutivo');
        $section->addText($lead->diagnosis_brief ?? '');
        $section->addText('Situación actual');
        $section->addText($lead->opportunities_summary ?? '');
        $section->addText('Recomendación');
        $section->addText($lead->recommendation ?? '');
        $section->addText('Procesos registrados');
        foreach ($lead->processes as $process) {
            $section->addText('- '.$process->name.' / '.$process->state.' / v'.$process->version);
        }

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function toAutomationPayload(Lead $lead): array
    {
        $lead = $this->loadGraph($lead);

        return [
            'summary' => [
                'company_name' => $lead->company_name,
                'ruc' => $lead->ruc,
                'industry' => $lead->industry,
                'maturity_score' => $lead->maturity_score,
                'maturity_level' => $lead->maturity_level,
                'version' => $lead->version,
                'consultant_name' => $lead->consultant_name,
                'source' => $lead->source,
                'lead_score_label' => $lead->leadScoreLabel(),
                'next_step' => $lead->nextStepRecommendation(),
                'annual_current_hours' => $lead->annualCurrentHours(),
                'annual_potential_hours' => $lead->annualPotentialHours(),
                'annual_savings_hours' => $lead->annualSavingsHours(),
                'estimated_savings_hours' => $lead->estimatedSavingsHours(),
            ],
            'narrative' => [
                'diagnosis_brief' => $lead->diagnosis_brief,
                'strengths' => $lead->strengthsSummary(),
                'opportunities' => $lead->opportunities_summary,
                'risks' => $lead->risksSummary(),
                'recommendation' => $lead->recommendation,
            ],
            'processes' => $lead->processes->map(fn (ProcessModel $process) => $this->serializeProcess($process))->values(),
            'routing' => [
                'whatsapp' => 'https://wa.me/51941108521',
                'web' => 'https://www.consultores-it.pe',
                'portal_login' => route('portal.login'),
                'diagnosis' => route('diagnosis.show', $lead),
            ],
        ];
    }

    private function clientPdfLines(Lead $lead): array
    {
        return [
            'Resumen ejecutivo',
            'Cliente: '.$lead->company_name,
            'Puntaje: '.$lead->maturity_score.'/100',
            'Nivel: '.$lead->maturity_level,
            'Lead scoring: '.$lead->leadScoreLabel(),
            'Horas actuales al año: '.$lead->annualCurrentHours(),
            'Horas potenciales con automatización: '.$lead->annualPotentialHours(),
            'Ahorro estimado anual: '.$lead->annualSavingsHours(),
            '',
            'Fortalezas',
            ...array_map(fn ($item) => '- '.$item, $lead->strengthsSummary()),
            '',
            'Oportunidades',
            '- '.$lead->opportunities_summary,
            '',
            'Riesgos detectados',
            ...array_map(fn ($item) => '- '.$item, $lead->risksSummary()),
            '',
            'Próximo paso recomendado',
            $lead->nextStepRecommendation(),
        ];
    }

    private function internalPdfLines(Lead $lead): array
    {
        $lines = [
            'Informe interno del consultor',
            'Cliente: '.$lead->company_name,
            'Lead scoring: '.$lead->leadScoreLabel(),
            'Próximo paso: '.$lead->nextStepRecommendation(),
            'Horas actuales al año: '.$lead->annualCurrentHours(),
            'Horas potenciales con automatización: '.$lead->annualPotentialHours(),
            'Ahorro estimado anual: '.$lead->annualSavingsHours(),
            '',
            'Resumen ejecutivo',
            $lead->diagnosis_brief ?? '',
            '',
            'Procesos registrados',
        ];

        foreach ($lead->processes as $process) {
            $lines[] = '- '.$process->name.' / '.$process->area.' / '.$process->state.' / v'.$process->version;
            foreach ($process->steps as $step) {
                $lines[] = '  Paso '.$step->step_number.': '.($step->title ?: $step->description);
            }
        }

        $lines[] = '';
        $lines[] = 'Fortalezas';
        foreach ($lead->strengthsSummary() as $item) {
            $lines[] = '- '.$item;
        }

        $lines[] = '';
        $lines[] = 'Riesgos';
        foreach ($lead->risksSummary() as $item) {
            $lines[] = '- '.$item;
        }

        $lines[] = '';
        $lines[] = 'Recomendación técnica';
        $lines[] = $lead->recommendation ?? '';

        return $lines;
    }

    private function loadGraph(Lead $lead): Lead
    {
        return $lead->loadMissing([
            'processes.creator',
            'processes.updater',
            'processes.templateProcess',
            'processes.steps',
            'processes.systems',
            'processes.documents',
            'processes.problems',
            'processes.opportunities',
            'processes.evaluations',
            'processes.backlogItems',
            'processes.stakeholders',
            'processes.dependencies.predecessorStep',
            'processes.dependencies.successorStep',
            'processes.decisions.step',
            'processes.exceptions.step',
            'processes.exceptions.systemIntegration',
            'processes.metrics',
            'processes.constraints',
            'processes.assumptions',
        ]);
    }

    private function serializeProcess(ProcessModel $process): array
    {
        return [
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
            'priority' => $process->priority,
            'consultant_name' => $process->consultant_name,
            'validated_at' => $process->validated_at?->toIso8601String(),
            'last_exported_at' => $process->last_exported_at?->toIso8601String(),
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
            'stakeholders' => $process->stakeholders->map(fn ($stakeholder) => $stakeholder->only([
                'name',
                'position',
                'area',
                'role',
                'participation_type',
                'email',
                'phone',
                'notes',
            ]))->values(),
            'dependencies' => $process->dependencies->map(fn ($item) => [
                'type' => $item->type,
                'condition' => $item->condition,
                'notes' => $item->notes,
                'predecessor_step' => $item->predecessorStep?->only(['step_number', 'title', 'description']),
                'successor_step' => $item->successorStep?->only(['step_number', 'title', 'description']),
            ])->values(),
            'decisions' => $process->decisions->map(fn ($item) => [
                'condition_evaluated' => $item->condition_evaluated,
                'decision_owner' => $item->decision_owner,
                'true_result' => $item->true_result,
                'false_result' => $item->false_result,
                'evidence' => $item->evidence,
                'step' => $item->step?->only(['step_number', 'title', 'description']),
            ])->values(),
            'exceptions' => $process->exceptions->map(fn ($item) => [
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
            'metrics' => $process->metrics->map(fn ($item) => $item->only([
                'name',
                'min_quantity',
                'avg_quantity',
                'max_quantity',
                'unit',
                'period',
                'source',
                'confirmed',
            ]))->values(),
            'constraints' => $process->constraints->map(fn ($item) => $item->only([
                'type',
                'description',
                'impact',
                'validation_owner',
                'status',
            ]))->values(),
            'assumptions' => $process->assumptions->map(fn ($item) => $item->only([
                'description',
                'impact',
                'validation_owner',
                'status',
            ]))->values(),
            'steps' => $process->steps->map(fn ($step) => $step->only([
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
            'evaluations' => $process->evaluations->map(fn ($item) => $item->only([
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
        ];
    }
}
