<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessDependency extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'process_id',
        'predecessor_step_id',
        'successor_step_id',
        'type',
        'condition',
        'notes',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }

    public function predecessorStep(): BelongsTo
    {
        return $this->belongsTo(ProcessStep::class, 'predecessor_step_id');
    }

    public function successorStep(): BelongsTo
    {
        return $this->belongsTo(ProcessStep::class, 'successor_step_id');
    }
}
