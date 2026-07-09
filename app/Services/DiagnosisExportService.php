<?php

namespace App\Services;

use App\Exports\DiagnosisWorkbookExport;
use App\Models\Lead;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DiagnosisExportService
{
    public function __construct(private readonly SimplePdfWriter $pdfWriter)
    {
    }

    public function toArray(Lead $lead): array
    {
        $lead->loadMissing([
            'processes.steps',
            'processes.systems',
            'processes.problems',
            'processes.opportunities',
            'processes.evaluations',
            'processes.backlogItems',
        ]);

        return [
            'client' => [
                'company_name' => $lead->company_name,
                'ruc' => $lead->ruc,
                'industry' => $lead->industry,
                'contact_name' => $lead->contact_name,
                'contact_role' => $lead->contact_role,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'maturity_score' => $lead->maturity_score,
                'maturity_level' => $lead->maturity_level,
                'diagnosis_brief' => $lead->diagnosis_brief,
                'opportunities_summary' => $lead->opportunities_summary,
                'recommendation' => $lead->recommendation,
                'lead_score_label' => $lead->leadScoreLabel(),
                'next_step' => $lead->nextStepRecommendation(),
                'strengths' => $lead->strengthsSummary(),
                'risks' => $lead->risksSummary(),
            ],
            'processes' => $lead->processes()->with([
                'steps',
            ])->get()->map(fn ($process) => [
                'name' => $process->name,
                'area' => $process->area,
                'owner' => $process->owner,
                'frequency' => $process->frequency,
                'objective' => $process->objective,
                'expected_result' => $process->expected_result,
                'trigger_event' => $process->trigger_event,
                'validation_method' => $process->validation_method,
                'status' => $process->status,
                'steps' => $process->steps->map(fn ($step) => $step->only([
                    'step_number',
                    'description',
                    'owner',
                    'system_used',
                    'input',
                    'output',
                    'estimated_minutes',
                    'evidence_generated',
                    'problems',
                    'automatable',
                    'comments',
                ])),
            ]),
            'systems' => $lead->processes()->with('systems')->get()->flatMap(fn ($process) => $process->systems->map(fn ($system) => $system->only([
                'name',
                'url',
                'system_type',
                'has_api',
                'auth_type',
                'access_owner',
                'access_status',
                'notes',
            ])))->values(),
            'opportunities' => $lead->processes->flatMap(fn ($process) => $process->opportunities->map(fn ($item) => $item->only([
                'activity',
                'current_time_minutes',
                'expected_time_minutes',
                'estimated_savings_minutes',
                'suggested_technology',
                'priority',
                'complexity',
                'status',
                'notes',
            ])))->values(),
            'evaluations' => $lead->processes->flatMap(fn ($process) => $process->evaluations->map(fn ($item) => $item->only([
                'complexity',
                'risk',
                'impact',
                'requires_mcp',
                'requires_hermes_skill',
                'requires_n8n',
                'requires_ai',
                'requires_ocr',
                'estimated_hours',
                'technical_notes',
            ])))->values(),
            'backlog' => $lead->processes->flatMap(fn ($process) => $process->backlogItems->map(fn ($item) => $item->only([
                'type',
                'title',
                'description',
                'acceptance_criteria',
                'priority',
                'responsible',
                'status',
                'estimated_hours',
            ])))->values(),
            'automation_payload' => $this->toAutomationPayload($lead),
        ];
    }

    public function toMarkdown(Lead $lead): string
    {
        $lead->loadMissing([
            'processes.steps',
            'processes.systems',
            'processes.problems',
            'processes.opportunities',
            'processes.evaluations',
            'processes.backlogItems',
        ]);

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
        $markdown[] = '';
        $markdown[] = '## Proceso';
        $markdown[] = '- Proceso principal: '.($process?->name ?? 'Pendiente de levantar');
        $markdown[] = '- Área: '.($process?->area ?? '-');
        $markdown[] = '- Responsable: '.($process?->owner ?? '-');
        $markdown[] = '';
        $markdown[] = '## Objetivo';
        $markdown[] = $process?->objective ?? 'Pendiente de definición';
        $markdown[] = '';
        $markdown[] = '## Sistemas involucrados';
        $hasSystems = false;
        foreach ($lead->processes()->with('systems')->get() as $item) {
            foreach ($item->systems as $system) {
                $hasSystems = true;
                $markdown[] = '- '.$system->name.' ('.$system->system_type.')';
            }
        }
        if (!$hasSystems) {
            $markdown[] = '- Pendiente de registrar sistemas.';
        }
        $markdown[] = '';
        $markdown[] = '## AS-IS';
        $markdown[] = '| Paso | Descripción | Responsable | Sistema | Entrada | Salida | Min | Evidencia | Problemas | Automatizable |';
        $markdown[] = '|---|---|---|---|---|---|---:|---|---|---|';
        foreach ($lead->processes as $item) {
            foreach ($item->steps as $step) {
                $markdown[] = '| '.$step->step_number.' | '.$step->description.' | '.$step->owner.' | '.$step->system_used.' | '.$step->input.' | '.$step->output.' | '.$step->estimated_minutes.' | '.$step->evidence_generated.' | '.$step->problems.' | '.$step->automatable.' |';
            }
        }
        $markdown[] = '';
        $markdown[] = '## Problemas actuales';
        $markdown[] = $lead->processes()->with('problems')->get()->flatMap(fn ($item) => $item->problems->map(fn ($problem) => '- '.$problem->description))->implode("\n") ?: '- Pendiente de registrar problemas.';
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
        return $this->pdfWriter->download(
            'diagnostico-cliente-'.$lead->ruc.'.pdf',
            'Informe del cliente - '.$lead->company_name,
            $this->clientPdfLines($lead)
        );
    }

    public function downloadInternalPdf(Lead $lead): BinaryFileResponse
    {
        return $this->pdfWriter->download(
            'diagnostico-interno-'.$lead->ruc.'.pdf',
            'Informe interno - '.$lead->company_name,
            $this->internalPdfLines($lead)
        );
    }

    public function downloadWord(Lead $lead): BinaryFileResponse
    {
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

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function toAutomationPayload(Lead $lead): array
    {
        $lead->loadMissing([
            'processes.steps',
            'processes.systems',
            'processes.problems',
            'processes.opportunities',
            'processes.evaluations',
            'processes.backlogItems',
        ]);

        return [
            'summary' => [
                'company_name' => $lead->company_name,
                'ruc' => $lead->ruc,
                'industry' => $lead->industry,
                'maturity_score' => $lead->maturity_score,
                'maturity_level' => $lead->maturity_level,
                'lead_score_label' => $lead->leadScoreLabel(),
                'next_step' => $lead->nextStepRecommendation(),
                'estimated_savings_hours' => $lead->estimatedSavingsHours(),
            ],
            'narrative' => [
                'diagnosis_brief' => $lead->diagnosis_brief,
                'strengths' => $lead->strengthsSummary(),
                'opportunities' => $lead->opportunities_summary,
                'risks' => $lead->risksSummary(),
                'recommendation' => $lead->recommendation,
            ],
            'processes' => $lead->processes->map(fn ($process) => [
                'name' => $process->name,
                'area' => $process->area,
                'owner' => $process->owner,
                'frequency' => $process->frequency,
                'objective' => $process->objective,
                'expected_result' => $process->expected_result,
                'steps' => $process->steps->map(fn ($step) => [
                    'step_number' => $step->step_number,
                    'description' => $step->description,
                    'owner' => $step->owner,
                    'system_used' => $step->system_used,
                    'input' => $step->input,
                    'output' => $step->output,
                    'estimated_minutes' => $step->estimated_minutes,
                    'automatable' => $step->automatable,
                ]),
            ]),
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
        $lead->loadMissing([
            'processes.steps',
            'processes.systems',
            'processes.problems',
            'processes.opportunities',
            'processes.evaluations',
            'processes.backlogItems',
        ]);

        $lines = [
            'Informe interno del consultor',
            'Cliente: '.$lead->company_name,
            'Lead scoring: '.$lead->leadScoreLabel(),
            'Próximo paso: '.$lead->nextStepRecommendation(),
            '',
            'Resumen ejecutivo',
            $lead->diagnosis_brief ?? '',
            '',
            'Fortalezas',
            ...array_map(fn ($item) => '- '.$item, $lead->strengthsSummary()),
            '',
            'Riesgos',
            ...array_map(fn ($item) => '- '.$item, $lead->risksSummary()),
            '',
            'Procesos',
        ];

        foreach ($lead->processes as $process) {
            $lines[] = '- '.$process->name.' / '.$process->area;
            foreach ($process->steps as $step) {
                $lines[] = '  Paso '.$step->step_number.': '.$step->description;
            }
        }

        $lines[] = '';
        $lines[] = 'Recomendación técnica';
        $lines[] = $lead->recommendation ?? '';

        return $lines;
    }
}
