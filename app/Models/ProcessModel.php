<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessModel extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $table = 'processes';

    protected $fillable = [
        'lead_id',
        'client_id',
        'name',
        'area',
        'owner',
        'frequency',
        'objective',
        'expected_result',
        'trigger_event',
        'validation_method',
        'status',
        'version',
        'state',
        'consultant_name',
        'created_by',
        'updated_by',
        'validated_at',
        'last_exported_at',
        'priority',
        'secondary_objectives',
        'business_problems',
        'completion_criteria',
        'start_event',
        'end_event',
        'frequency_number',
        'frequency_period',
        'context_for_ai',
        'category',
        'sector',
        'tags',
        'template_process_id',
        'notes',
    ];

    protected $casts = [
        'version' => 'integer',
        'validated_at' => 'datetime',
        'last_exported_at' => 'datetime',
        'frequency_number' => 'integer',
        'tags' => 'array',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function templateProcess(): BelongsTo
    {
        return $this->belongsTo(self::class, 'template_process_id');
    }

    public function derivedProcesses(): HasMany
    {
        return $this->hasMany(self::class, 'template_process_id');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(ProcessStep::class, 'process_id')->orderBy('step_number');
    }

    public function systems(): HasMany
    {
        return $this->hasMany(SystemIntegration::class, 'process_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(DocumentEvidence::class, 'process_id');
    }

    public function problems(): HasMany
    {
        return $this->hasMany(CurrentProblem::class, 'process_id');
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(AutomationOpportunity::class, 'process_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(InternalEvaluation::class, 'process_id');
    }

    public function backlogItems(): HasMany
    {
        return $this->hasMany(BacklogItem::class, 'process_id');
    }

    public function stakeholders(): HasMany
    {
        return $this->hasMany(ProcessStakeholder::class, 'process_id');
    }

    public function dependencies(): HasMany
    {
        return $this->hasMany(ProcessDependency::class, 'process_id');
    }

    public function decisions(): HasMany
    {
        return $this->hasMany(ProcessDecision::class, 'process_id');
    }

    public function exceptions(): HasMany
    {
        return $this->hasMany(ProcessException::class, 'process_id');
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(ProcessMetric::class, 'process_id');
    }

    public function constraints(): HasMany
    {
        return $this->hasMany(ProcessConstraint::class, 'process_id');
    }

    public function assumptions(): HasMany
    {
        return $this->hasMany(ProcessAssumption::class, 'process_id');
    }
}
