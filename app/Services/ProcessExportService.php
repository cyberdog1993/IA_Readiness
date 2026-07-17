<?php

namespace App\Services;

use App\Models\ProcessModel;

class ProcessExportService
{
    public function toArray(ProcessModel $process): array
    {
        $process->loadMissing([
            'client.lead',
            'steps',
            'systems',
            'documents',
            'problems',
            'opportunities',
            'evaluations',
            'backlogItems',
        ]);

        return [
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
            ],
            'as_is' => $process->steps->map(fn ($step) => $step->only([
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
            ]))->values(),
            'systems' => $process->systems->map(fn ($system) => $system->only([
                'name',
                'url',
                'system_type',
                'has_api',
                'auth_type',
                'access_owner',
                'access_status',
                'notes',
            ]))->values(),
            'documents' => $process->documents->map(fn ($document) => $document->only([
                'name',
                'type',
                'format',
                'location',
                'owner',
                'mandatory',
                'notes',
            ]))->values(),
            'problems' => $process->problems->map(fn ($problem) => $problem->only([
                'description',
                'impact',
                'frequency',
                'risk',
                'comments',
            ]))->values(),
            'opportunities' => $process->opportunities->map(fn ($item) => $item->only([
                'activity',
                'current_time_minutes',
                'expected_time_minutes',
                'estimated_savings_minutes',
                'suggested_technology',
                'priority',
                'complexity',
                'status',
                'notes',
            ]))->values(),
            'internal_evaluation' => $process->evaluations->map(fn ($item) => $item->only([
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
            ]))->values(),
            'backlog' => $process->backlogItems->map(fn ($item) => $item->only([
                'type',
                'title',
                'description',
                'acceptance_criteria',
                'priority',
                'responsible',
                'status',
                'estimated_hours',
            ]))->values(),
            'automation_prompt' => $this->automationPrompt($process),
        ];
    }

    public function toMarkdown(ProcessModel $process): string
    {
        $process->loadMissing([
            'client',
            'steps',
            'systems',
            'documents',
            'problems',
            'opportunities',
            'evaluations',
            'backlogItems',
        ]);

        $lines = [];
        $lines[] = '# Diagnóstico de Automatización - '.$process->client?->business_name;
        $lines[] = '';
        $lines[] = '## Cliente';
        $lines[] = '- Razón social: '.$process->client?->business_name;
        $lines[] = '- RUC: '.$process->client?->ruc;
        $lines[] = '- Rubro: '.$process->client?->industry;
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
        $lines[] = '';
        $lines[] = '## Sistemas involucrados';
        if ($process->systems->isEmpty()) {
            $lines[] = '- Pendiente de registrar sistemas.';
        } else {
            foreach ($process->systems as $system) {
                $lines[] = '- '.$system->name.' ('.$system->system_type.')';
            }
        }
        $lines[] = '';
        $lines[] = '## AS-IS';
        $lines[] = '| Paso | Descripción | Responsable | Sistema | Entrada | Salida | Min | Evidencia | Problemas | Automatizable |';
        $lines[] = '|---|---|---|---|---|---|---:|---|---|---|';
        foreach ($process->steps as $step) {
            $lines[] = '| '.$step->step_number.' | '.$step->description.' | '.$step->owner.' | '.$step->system_used.' | '.$step->input.' | '.$step->output.' | '.$step->estimated_minutes.' | '.$step->evidence_generated.' | '.$step->problems.' | '.$step->automatable.' |';
        }
        $lines[] = '';
        $lines[] = '## Problemas actuales';
        if ($process->problems->isEmpty()) {
            $lines[] = '- Pendiente de registrar problemas.';
        } else {
            foreach ($process->problems as $problem) {
                $lines[] = '- '.$problem->description.' ('.$problem->impact.')';
            }
        }
        $lines[] = '';
        $lines[] = '## Documentos y evidencias';
        if ($process->documents->isEmpty()) {
            $lines[] = '- Pendiente de registrar documentos.';
        } else {
            foreach ($process->documents as $document) {
                $lines[] = '- '.$document->name.' / '.$document->type.' / '.$document->format;
            }
        }
        $lines[] = '';
        $lines[] = '## Oportunidades de automatización';
        if ($process->opportunities->isEmpty()) {
            $lines[] = '- Pendiente de consolidar oportunidades.';
        } else {
            foreach ($process->opportunities as $item) {
                $lines[] = '- '.$item->activity.' / '.$item->suggested_technology.' / '.$item->priority;
            }
        }
        $lines[] = '';
        $lines[] = '## Evaluación interna';
        if ($process->evaluations->isEmpty()) {
            $lines[] = '- Pendiente de evaluación técnica.';
        } else {
            foreach ($process->evaluations as $item) {
                $lines[] = '- Complejidad: '.$item->complexity.' | Riesgo: '.$item->risk.' | Impacto: '.$item->impact.' | Horas: '.$item->estimated_hours;
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
        $lines[] = '## Recomendación técnica';
        $lines[] = $this->automationPrompt($process);

        return implode("\n", $lines);
    }

    public function automationPrompt(ProcessModel $process): string
    {
        return 'Resume este proceso, identifica oportunidades, riesgos, ROI estimado, roadmap y una propuesta preliminar para '.$process->client?->business_name.' / '.$process->name.'.';
    }

    public function toPdfLines(ProcessModel $process): array
    {
        $process->loadMissing(['client', 'steps', 'systems', 'documents', 'problems', 'opportunities', 'evaluations', 'backlogItems']);

        $lines = [
            'Cliente: '.$process->client?->business_name,
            'Proceso: '.$process->name,
            'Área: '.($process->area ?: '-'),
            'Responsable: '.($process->owner ?: '-'),
            'Frecuencia: '.($process->frequency ?: '-'),
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
        $lines[] = 'AS-IS';
        foreach ($process->steps as $step) {
            $lines[] = 'Paso '.$step->step_number.': '.$step->description.' | '.$step->owner.' | '.$step->system_used.' | '.$step->automatable;
        }

        $lines[] = '';
        $lines[] = 'Problemas actuales';
        foreach ($process->problems as $problem) {
            $lines[] = '- '.$problem->description.' ('.$problem->impact.')';
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
}
