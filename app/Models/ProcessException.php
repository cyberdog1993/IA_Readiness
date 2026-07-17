<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessException extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'process_id',
        'step_id',
        'system_integration_id',
        'trigger',
        'current_action',
        'owner',
        'resolution_time_minutes',
        'severity',
        'retry_possible',
        'escalation_rule',
    ];

    protected $casts = [
        'resolution_time_minutes' => 'integer',
        'retry_possible' => 'boolean',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }

    public function step(): BelongsTo
    {
        return $this->belongsTo(ProcessStep::class, 'step_id');
    }

    public function systemIntegration(): BelongsTo
    {
        return $this->belongsTo(SystemIntegration::class, 'system_integration_id');
    }
}
