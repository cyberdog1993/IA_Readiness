<?php

namespace App\Services;

use App\Models\Lead;

class MaturityCalculator
{
    public function evaluate(array $data): array
    {
        $scores = [
            'processes_documented' => $this->clamp($data['process_documentation_level'] ?? 0),
            'task_repetitiveness' => $this->scoreRepetitiveness($data),
            'digital_system_usage' => $this->clamp($data['digital_system_usage'] ?? 0),
            'system_integration' => $this->clamp($data['system_integration_level'] ?? 0),
            'data_quality' => $this->scoreDataQuality($data),
            'kpi_measurement' => $this->scoreKpis($data),
            'operational_volume' => $this->scoreOperationalVolume($data),
            'cultural_readiness' => $this->scoreCulture($data),
        ];

        $weighted = (
            $scores['processes_documented'] * 0.15 +
            $scores['task_repetitiveness'] * 0.15 +
            $scores['digital_system_usage'] * 0.15 +
            $scores['system_integration'] * 0.15 +
            $scores['data_quality'] * 0.15 +
            $scores['kpi_measurement'] * 0.10 +
            $scores['operational_volume'] * 0.10 +
            $scores['cultural_readiness'] * 0.05
        );

        $score = (int) round(max(0, min(100, $weighted)));
        $level = match (true) {
            $score <= 30 => 'Bajo',
            $score <= 55 => 'Inicial',
            $score <= 75 => 'Intermedio',
            $score <= 90 => 'Avanzado',
            default => 'Listo para automatizar',
        };

        [$diagnosis, $opportunities, $recommendation] = $this->composeNarrative($score, $level, $data);

        return [
            'score' => $score,
            'level' => $level,
            'diagnosis_brief' => $diagnosis,
            'opportunities_summary' => $opportunities,
            'recommendation' => $recommendation,
            'scores' => $scores,
        ];
    }

    public function updateLead(Lead $lead, array $data): Lead
    {
        $evaluation = $this->evaluate($data);

        $lead->fill(array_merge($data, [
            'maturity_score' => $evaluation['score'],
            'maturity_level' => $evaluation['level'],
            'diagnosis_brief' => $evaluation['diagnosis_brief'],
            'opportunities_summary' => $evaluation['opportunities_summary'],
            'recommendation' => $evaluation['recommendation'],
        ]));

        $lead->save();

        return $lead;
    }

    private function scoreRepetitiveness(array $data): int
    {
        $repetitive = (int) ($data['repetitive_process_count'] ?? 0);
        $manualHours = (int) ($data['manual_hours_weekly'] ?? 0);
        $excel = (int) ($data['excel_dependency'] ?? 0);
        $reports = (int) ($data['manual_report_generation'] ?? 0);

        return (int) round(min(100, (
            min($repetitive, 20) * 3 +
            min($manualHours, 40) * 1.2 +
            $excel * 0.15 +
            $reports * 0.15
        )));
    }

    private function scoreDataQuality(array $data): int
    {
        $systemUsage = (int) ($data['digital_system_usage'] ?? 0);
        $integration = (int) ($data['system_integration_level'] ?? 0);
        $excel = (int) ($data['excel_dependency'] ?? 0);
        $manualReports = (int) ($data['manual_report_generation'] ?? 0);

        return (int) round(max(0, min(100, 100 - (($excel * 0.4) + ($manualReports * 0.3)) + (($systemUsage + $integration) * 0.25))));
    }

    private function scoreKpis(array $data): int
    {
        return empty($data['has_kpis']) ? 20 : 100;
    }

    private function scoreOperationalVolume(array $data): int
    {
        $repetitive = (int) ($data['repetitive_process_count'] ?? 0);
        $hours = (int) ($data['manual_hours_weekly'] ?? 0);

        return (int) round(min(100, ($repetitive * 2.5) + ($hours * 2)));
    }

    private function scoreCulture(array $data): int
    {
        $interest = (int) ($data['automation_interest'] ?? 0);
        $keyPeople = (int) ($data['key_person_dependency'] ?? 0);

        return (int) round(max(0, min(100, ($interest * 0.7) + ((100 - $keyPeople) * 0.3))));
    }

    private function clamp(int $value): int
    {
        return max(0, min(100, $value));
    }

    private function composeNarrative(int $score, string $level, array $data): array
    {
        $diagnosis = match ($level) {
            'Bajo' => 'La operación muestra baja preparación para automatizar; conviene ordenar procesos y datos antes de invertir en automatización compleja.',
            'Inicial' => 'Existen señales tempranas de automatización, pero todavía hay dependencia manual alta y poca estandarización.',
            'Intermedio' => 'Hay una base viable para automatización selectiva con quick wins y mejora de integraciones.',
            'Avanzado' => 'La organización está cerca de capturar valor rápido con automatizaciones asistidas por IA, n8n y MCP.',
            default => 'La organización está lista para automatizar con un enfoque por oleadas, gobierno y medición de impacto.',
        };

        $opportunities = [];

        if ((int) ($data['manual_hours_weekly'] ?? 0) >= 20) {
            $opportunities[] = 'Reducir horas manuales con automatización de tareas repetitivas y reportes.';
        }

        if ((int) ($data['system_integration_level'] ?? 0) < 60) {
            $opportunities[] = 'Conectar sistemas con APIs, MCP o RPA donde no exista integración nativa.';
        }

        if (!empty($data['has_kpis']) === false) {
            $opportunities[] = 'Definir KPIs y medición de tiempos para medir retorno de cada automatización.';
        }

        if ((int) ($data['excel_dependency'] ?? 0) >= 50) {
            $opportunities[] = 'Sustituir Excel operativo por flujos estructurados con validación de datos.';
        }

        if ($opportunities === []) {
            $opportunities[] = 'Optimizar una primera ola de automatizaciones de alto impacto y baja complejidad.';
        }

        $recommendation = $score >= 76
            ? 'Proponer un piloto inmediato sobre el proceso con mayor ahorro estimado y diseñar el backlog técnico.'
            : 'Iniciar con diagnóstico detallado AS-IS, normalización de datos y selección de oportunidades rápidas.';

        return [
            $diagnosis,
            implode(' ', $opportunities),
            $recommendation,
        ];
    }
}
