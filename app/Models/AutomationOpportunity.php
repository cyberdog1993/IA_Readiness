<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomationOpportunity extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $table = 'automation_opportunities';

    protected $fillable = [
        'process_id',
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
    ];

    protected $casts = [
        'current_time_minutes' => 'integer',
        'expected_time_minutes' => 'integer',
        'estimated_savings_minutes' => 'integer',
        'execution_volume' => 'integer',
        'monthly_savings_minutes' => 'integer',
        'annual_savings_minutes' => 'integer',
        'automation_percentage' => 'integer',
        'human_validation_required' => 'boolean',
        'confidence' => 'integer',
        'complexity' => 'integer',
        'technologies' => 'array',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}
