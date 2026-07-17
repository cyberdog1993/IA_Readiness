<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DiagnosisWorkbookExport implements WithMultipleSheets
{
    public function __construct(private readonly Lead $lead)
    {
    }

    public function sheets(): array
    {
        $lead = $this->lead->loadMissing([
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

        $process = $lead->processes->first();

        $processRows = $process ? [[
            $process->name,
            $process->area,
            $process->owner,
            $process->frequency,
            $process->objective,
            $process->expected_result,
            $process->trigger_event,
            $process->validation_method,
            $process->status,
            $process->version,
            $process->state,
            $process->priority,
            $process->consultant_name,
            $process->category,
            $process->sector,
        ]] : [];

        return [
            new Sheets\SimpleArraySheet('Cliente', [
                ['Empresa', 'RUC', 'Rubro', 'Contacto', 'Cargo', 'Correo', 'Teléfono', 'Madurez', 'Nivel', 'Versión', 'Consultor', 'Fuente'],
                [
                    $lead->company_name,
                    $lead->ruc,
                    $lead->industry,
                    $lead->contact_name,
                    $lead->contact_role,
                    $lead->email,
                    $lead->phone,
                    $lead->maturity_score,
                    $lead->maturity_level,
                    $lead->version,
                    $lead->consultant_name,
                    $lead->source,
                ],
            ]),
            new Sheets\SimpleArraySheet('Proceso', $this->rows([
                ['Proceso', 'Área', 'Responsable', 'Frecuencia', 'Objetivo', 'Resultado esperado', 'Evento inicial', 'Validación', 'Estado', 'Versión', 'Estado interno', 'Prioridad', 'Consultor', 'Categoría', 'Sector'],
            ], $processRows)),
            new Sheets\SimpleArraySheet('AS-IS', $this->rows([
                ['Proceso', 'Paso', 'Título', 'Descripción', 'Responsable', 'Sistema', 'Entrada', 'Salida', 'Minutos', 'Mín', 'Prom', 'Máx', 'Espera', 'Volumen', 'Tipo', 'Valida humano', 'Evidencia', 'Problemas', 'Automatizable', 'Comentarios'],
            ], $process ? $process->steps->map(fn ($step) => [
                $process->name,
                $step->step_number,
                $step->title,
                $step->description,
                $step->owner,
                $step->system_used,
                $step->input,
                $step->output,
                $step->estimated_minutes,
                $step->min_minutes,
                $step->avg_minutes,
                $step->max_minutes,
                $step->wait_minutes,
                $step->frequency_volume,
                $step->execution_type,
                $step->requires_human_validation ? 'Sí' : 'No',
                $step->evidence_generated,
                $step->problems,
                $step->automatable,
                $step->comments,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Sistemas', $this->rows([
                ['Cliente', 'Proceso', 'Sistema', 'URL', 'Tipo', 'Descripción', 'API', 'Tipo API', 'Versión API', 'Webhooks', 'Autenticación', 'Responsable', 'Estado', 'Detalle', 'Restricciones', 'Observaciones'],
            ], $process ? $process->systems->map(fn ($system) => [
                $lead->company_name,
                $process->name,
                $system->name,
                $system->url,
                $system->system_type,
                $system->description,
                $system->has_api ? 'Sí' : 'No',
                $system->api_type,
                $system->api_version,
                $system->webhooks_available ? 'Sí' : 'No',
                $system->auth_type,
                $system->access_owner,
                $system->access_status,
                $system->access_status_detail,
                $system->restrictions,
                $system->notes,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Stakeholders', $this->rows([
                ['Proceso', 'Nombre', 'Cargo', 'Área', 'Rol', 'Participación', 'Correo', 'Teléfono', 'Notas'],
            ], $process ? $process->stakeholders->map(fn ($item) => [
                $process->name,
                $item->name,
                $item->position,
                $item->area,
                $item->role,
                $item->participation_type,
                $item->email,
                $item->phone,
                $item->notes,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Dependencias', $this->rows([
                ['Proceso', 'Tipo', 'Condición', 'Predecesor', 'Sucesor', 'Notas'],
            ], $process ? $process->dependencies->map(fn ($item) => [
                $process->name,
                $item->type,
                $item->condition,
                $item->predecessorStep?->step_number.' - '.($item->predecessorStep?->title ?: $item->predecessorStep?->description),
                $item->successorStep?->step_number.' - '.($item->successorStep?->title ?: $item->successorStep?->description),
                $item->notes,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Decisiones', $this->rows([
                ['Proceso', 'Paso', 'Condición', 'Responsable', 'Resultado verdadero', 'Resultado falso', 'Evidencia'],
            ], $process ? $process->decisions->map(fn ($item) => [
                $process->name,
                $item->step?->step_number,
                $item->condition_evaluated,
                $item->decision_owner,
                $item->true_result,
                $item->false_result,
                $item->evidence,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Excepciones', $this->rows([
                ['Proceso', 'Paso', 'Sistema', 'Disparador', 'Acción actual', 'Responsable', 'Tiempo resolución', 'Severidad', 'Reintento', 'Escalada'],
            ], $process ? $process->exceptions->map(fn ($item) => [
                $process->name,
                $item->step?->step_number,
                $item->systemIntegration?->name,
                $item->trigger,
                $item->current_action,
                $item->owner,
                $item->resolution_time_minutes,
                $item->severity,
                $item->retry_possible ? 'Sí' : 'No',
                $item->escalation_rule,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Métricas', $this->rows([
                ['Proceso', 'Métrica', 'Mín', 'Prom', 'Máx', 'Unidad', 'Periodo', 'Fuente', 'Confirmada'],
            ], $process ? $process->metrics->map(fn ($item) => [
                $process->name,
                $item->name,
                $item->min_quantity,
                $item->avg_quantity,
                $item->max_quantity,
                $item->unit,
                $item->period,
                $item->source,
                $item->confirmed ? 'Sí' : 'No',
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Restricciones', $this->rows([
                ['Proceso', 'Tipo', 'Descripción', 'Impacto', 'Validación', 'Estado'],
            ], $process ? $process->constraints->map(fn ($item) => [
                $process->name,
                $item->type,
                $item->description,
                $item->impact,
                $item->validation_owner,
                $item->status,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Supuestos', $this->rows([
                ['Proceso', 'Descripción', 'Impacto', 'Validación', 'Estado'],
            ], $process ? $process->assumptions->map(fn ($item) => [
                $process->name,
                $item->description,
                $item->impact,
                $item->validation_owner,
                $item->status,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Problemas', $this->rows([
                ['Proceso', 'Descripción', 'Disparador', 'Acción actual', 'Impacto', 'Frecuencia', 'Riesgo', 'Severidad', 'Reintento', 'Comentarios'],
            ], $process ? $process->problems->map(fn ($problem) => [
                $process->name,
                $problem->description,
                $problem->trigger,
                $problem->current_action,
                $problem->impact,
                $problem->frequency,
                $problem->risk,
                $problem->severity,
                $problem->retry_possible ? 'Sí' : 'No',
                $problem->comments,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Automatización', $this->rows([
                ['Proceso', 'Actividad', 'Problema', 'Tiempo actual', 'Tiempo esperado', 'Ahorro', 'Tiempo actual periodo', 'Tiempo esperado periodo', 'Volumen', 'Ahorro mensual', 'Ahorro anual', 'Cobertura', 'Validación humana', 'Confianza', 'Tecnología', 'Dependencias', 'Prioridad', 'Complejidad', 'Estado', 'Notas'],
            ], $process ? $process->opportunities->map(fn ($item) => [
                $process->name,
                $item->activity,
                $item->problem,
                $item->current_time_minutes,
                $item->expected_time_minutes,
                $item->estimated_savings_minutes,
                $item->current_time_period,
                $item->expected_time_period,
                $item->execution_volume,
                $item->monthly_savings_minutes,
                $item->annual_savings_minutes,
                $item->automation_percentage,
                $item->human_validation_required ? 'Sí' : 'No',
                $item->confidence,
                $item->suggested_technology,
                is_array($item->technologies) ? implode(', ', $item->technologies) : $item->technologies,
                $item->dependencies,
                $item->priority,
                $item->complexity,
                $item->status,
                $item->notes,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Evaluación interna', $this->rows([
                ['Proceso', 'Complejidad', 'Riesgo', 'Impacto', 'Confianza', 'MCP', 'Hermes', 'n8n', 'IA', 'OCR', 'Horas', 'Integraciones', 'Seguridad', 'Fase 1', 'Fase 2', 'Fase 3', 'Responsable', 'Estado', 'Tecnologías', 'Dependencias', 'Notas'],
            ], $process ? $process->evaluations->map(fn ($evaluation) => [
                $process->name,
                $evaluation->complexity,
                $evaluation->risk,
                $evaluation->impact,
                $evaluation->confidence,
                $evaluation->requires_mcp ? 'Sí' : 'No',
                $evaluation->requires_hermes_skill ? 'Sí' : 'No',
                $evaluation->requires_n8n ? 'Sí' : 'No',
                $evaluation->requires_ai ? 'Sí' : 'No',
                $evaluation->requires_ocr ? 'Sí' : 'No',
                $evaluation->estimated_hours,
                $evaluation->integrations_required,
                $evaluation->security_requirements,
                $evaluation->hours_phase_1,
                $evaluation->hours_phase_2,
                $evaluation->hours_phase_3,
                $evaluation->responsible,
                $evaluation->review_state,
                is_array($evaluation->candidate_technologies) ? implode(', ', $evaluation->candidate_technologies) : $evaluation->candidate_technologies,
                $evaluation->dependencies,
                $evaluation->technical_notes,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Tareas', $this->rows([
                ['Proceso', 'Épica', 'Tipo', 'Título', 'Descripción', 'Criterios', 'Prioridad', 'Responsable', 'Estado', 'Horas', 'Dependencias', 'Origen', 'Fase', 'Vence'],
            ], $process ? $process->backlogItems->map(fn ($item) => [
                $process->name,
                $item->epic,
                $item->type,
                $item->title,
                $item->description,
                $item->acceptance_criteria,
                $item->priority,
                $item->responsible,
                $item->status,
                $item->estimated_hours,
                $item->dependencies,
                $item->origin,
                $item->phase,
                $item->due_date?->format('Y-m-d'),
            ])->all() : [])),
        ];
    }

    private function rows(array $header, array $rows): array
    {
        return array_merge($header, $rows);
    }
}
