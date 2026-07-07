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
    ];

    protected $casts = [
        'step_number' => 'integer',
        'estimated_minutes' => 'integer',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}

