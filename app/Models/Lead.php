<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'company_name',
        'ruc',
        'industry',
        'contact_name',
        'contact_role',
        'email',
        'phone',
        'company_size',
        'repetitive_process_count',
        'manual_hours_weekly',
        'process_documentation_level',
        'digital_system_usage',
        'excel_dependency',
        'system_integration_level',
        'manual_report_generation',
        'has_kpis',
        'key_person_dependency',
        'automation_interest',
        'privacy_consent',
        'maturity_score',
        'maturity_level',
        'diagnosis_brief',
        'opportunities_summary',
        'recommendation',
        'consulting_requested_at',
        'status',
    ];

    protected $casts = [
        'manual_hours_weekly' => 'integer',
        'repetitive_process_count' => 'integer',
        'process_documentation_level' => 'integer',
        'digital_system_usage' => 'integer',
        'excel_dependency' => 'integer',
        'system_integration_level' => 'integer',
        'manual_report_generation' => 'integer',
        'has_kpis' => 'boolean',
        'key_person_dependency' => 'integer',
        'automation_interest' => 'integer',
        'privacy_consent' => 'boolean',
        'maturity_score' => 'integer',
        'consulting_requested_at' => 'datetime',
    ];

    public function estimatedSavingsHours(): float
    {
        $manualHours = (int) $this->manual_hours_weekly;
        $score = (int) $this->maturity_score;

        return round($manualHours * max(0.15, min(0.85, $score / 130)), 1);
    }

    public function recommendedProcesses(): array
    {
        $recommendations = [];

        if ((int) $this->manual_report_generation >= 50 || (int) $this->excel_dependency >= 50) {
            $recommendations[] = 'Reportes operativos y control gerencial';
        }

        if ((int) $this->system_integration_level < 60) {
            $recommendations[] = 'Integración entre sistemas y consolidación de datos';
        }

        if ((int) $this->repetitive_process_count >= 10 || (int) $this->manual_hours_weekly >= 20) {
            $recommendations[] = 'Tareas repetitivas de alto volumen';
        }

        if ($recommendations === []) {
            $recommendations[] = 'Primer piloto de automatización de bajo riesgo';
        }

        return array_values(array_unique($recommendations));
    }

    public function leadScoreLabel(): string
    {
        return match (true) {
            $this->maturity_score >= 80 => 'Lead caliente',
            $this->maturity_score >= 60 => 'Reunión esta semana',
            $this->maturity_score >= 40 => 'Enviar contenido y propuesta inicial',
            default => 'Requiere fase previa de organización',
        };
    }

    public function nextStepRecommendation(): string
    {
        return match (true) {
            $this->maturity_score >= 80 => 'Contactar hoy y agendar reunión ejecutiva.',
            $this->maturity_score >= 60 => 'Programar reunión esta semana y validar alcance.',
            $this->maturity_score >= 40 => 'Enviar contenido, ejemplo y propuesta inicial.',
            default => 'Compartir guía de ordenamiento y reingresar en fase de diagnóstico.',
        };
    }

    public function strengthsSummary(): array
    {
        $strengths = [];

        if ((int) $this->digital_system_usage >= 60) {
            $strengths[] = 'Ya existe adopción de sistemas digitales.';
        }

        if ((int) $this->automation_interest >= 60) {
            $strengths[] = 'Hay interés real en automatizar.';
        }

        if ((bool) $this->has_kpis) {
            $strengths[] = 'La operación ya mide al menos una parte del desempeño.';
        }

        if ((int) $this->process_documentation_level >= 50) {
            $strengths[] = 'Existe una base documental útil para acelerar levantamiento.';
        }

        return $strengths ?: ['Aún está por consolidarse una base operativa para automatizar con rapidez.'];
    }

    public function risksSummary(): array
    {
        $risks = [];

        if ((int) $this->key_person_dependency >= 50) {
            $risks[] = 'Dependencia alta de personas clave.';
        }

        if ((int) $this->manual_report_generation >= 50) {
            $risks[] = 'Exceso de reportes manuales y reprocesos.';
        }

        if ((int) $this->system_integration_level < 50) {
            $risks[] = 'Integraciones insuficientes entre sistemas.';
        }

        if ((int) $this->excel_dependency >= 50) {
            $risks[] = 'Uso crítico de Excel como sistema operativo.';
        }

        return $risks ?: ['Riesgo bajo detectado, pero se recomienda validar el levantamiento AS-IS.'];
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function processes(): HasMany
    {
        return $this->hasMany(ProcessModel::class, 'lead_id');
    }
}
