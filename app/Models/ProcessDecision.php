<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessDecision extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'process_id',
        'step_id',
        'condition_evaluated',
        'decision_owner',
        'true_result',
        'false_result',
        'evidence',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }

    public function step(): BelongsTo
    {
        return $this->belongsTo(ProcessStep::class, 'step_id');
    }
}
