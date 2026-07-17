<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessStep extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $table = 'process_steps';

    protected $fillable = [
        'process_id',
        'step_number',
        'title',
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
    ];

    protected $casts = [
        'step_number' => 'integer',
        'estimated_minutes' => 'integer',
        'min_minutes' => 'integer',
        'avg_minutes' => 'integer',
        'max_minutes' => 'integer',
        'wait_minutes' => 'integer',
        'frequency_volume' => 'integer',
        'requires_human_validation' => 'boolean',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}
