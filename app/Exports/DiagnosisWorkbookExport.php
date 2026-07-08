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
            'processes.problems',
            'processes.opportunities',
            'processes.evaluations',
            'processes.backlogItems',
        ]);

        $process = $lead->processes->first();

        return [
            new Sheets\SimpleArraySheet('Cliente', [
                ['Empresa', 'RUC', 'Rubro', 'Contacto', 'Cargo', 'Correo', 'Teléfono', 'Madurez', 'Nivel'],
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
                ],
            ]),
            new Sheets\SimpleArraySheet('Proceso', $this->rows([
                ['Proceso', 'Área', 'Responsable', 'Frecuencia', 'Objetivo', 'Resultado esperado', 'Evento inicial', 'Validación', 'Estado'],
            ], $process ? [[
                $process->name,
                $process->area,
                $process->owner,
                $process->frequency,
                $process->objective,
                $process->expected_result,
                $process->trigger_event,
                $process->validation_method,
                $process->status,
            ]] : [])),
            new Sheets\SimpleArraySheet('AS-IS', $this->rows([
                ['Proceso', 'Paso', 'Descripción', 'Responsable', 'Sistema', 'Entrada', 'Salida', 'Minutos', 'Evidencia', 'Problemas', 'Automatizable', 'Comentarios'],
            ], $process ? $process->steps->map(fn ($step) => [
                $process->name,
                $step->step_number,
                $step->description,
                $step->owner,
                $step->system_used,
                $step->input,
                $step->output,
                $step->estimated_minutes,
                $step->evidence_generated,
                $step->problems,
                $step->automatable,
                $step->comments,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Sistemas', $this->rows([
                ['Cliente', 'Proceso', 'Sistema', 'URL', 'Tipo', 'API', 'Autenticación', 'Responsable', 'Estado', 'Observaciones'],
            ], $process ? $process->systems->map(fn ($system) => [
                $lead->company_name,
                $process->name,
                $system->name,
                $system->url,
                $system->system_type,
                $system->has_api ? 'Sí' : 'No',
                $system->auth_type,
                $system->access_owner,
                $system->access_status,
                $system->notes,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Problemas', $this->rows([
                ['Proceso', 'Descripción', 'Impacto', 'Frecuencia', 'Riesgo', 'Comentarios'],
            ], $process ? $process->problems->map(fn ($problem) => [
                $process->name,
                $problem->description,
                $problem->impact,
                $problem->frequency,
                $problem->risk,
                $problem->comments,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Automatización', $this->rows([
                ['Proceso', 'Actividad', 'Tiempo actual', 'Tiempo esperado', 'Ahorro', 'Tecnología', 'Prioridad', 'Complejidad', 'Estado', 'Notas'],
            ], $process ? $process->opportunities->map(fn ($item) => [
                $process->name,
                $item->activity,
                $item->current_time_minutes,
                $item->expected_time_minutes,
                $item->estimated_savings_minutes,
                $item->suggested_technology,
                $item->priority,
                $item->complexity,
                $item->status,
                $item->notes,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Evaluación interna', $this->rows([
                ['Proceso', 'Complejidad', 'Riesgo', 'Impacto', 'MCP', 'Hermes', 'n8n', 'IA', 'OCR', 'Horas', 'Notas'],
            ], $process ? $process->evaluations->map(fn ($evaluation) => [
                $process->name,
                $evaluation->complexity,
                $evaluation->risk,
                $evaluation->impact,
                $evaluation->requires_mcp ? 'Sí' : 'No',
                $evaluation->requires_hermes_skill ? 'Sí' : 'No',
                $evaluation->requires_n8n ? 'Sí' : 'No',
                $evaluation->requires_ai ? 'Sí' : 'No',
                $evaluation->requires_ocr ? 'Sí' : 'No',
                $evaluation->estimated_hours,
                $evaluation->technical_notes,
            ])->all() : [])),
            new Sheets\SimpleArraySheet('Tareas', $this->rows([
                ['Proceso', 'Tipo', 'Título', 'Descripción', 'Criterios', 'Prioridad', 'Responsable', 'Estado', 'Horas'],
            ], $process ? $process->backlogItems->map(fn ($item) => [
                $process->name,
                $item->type,
                $item->title,
                $item->description,
                $item->acceptance_criteria,
                $item->priority,
                $item->responsible,
                $item->status,
                $item->estimated_hours,
            ])->all() : [])),
        ];
    }

    private function rows(array $header, array $rows): array
    {
        return array_merge($header, $rows);
    }
}
