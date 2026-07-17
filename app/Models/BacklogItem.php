<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BacklogItem extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $table = 'backlog_items';

    protected $fillable = [
        'process_id',
        'epic',
        'type',
        'title',
        'description',
        'acceptance_criteria',
        'priority',
        'responsible',
        'status',
        'estimated_hours',
        'dependencies',
        'origin',
        'phase',
        'due_date',
    ];

    protected $casts = [
        'estimated_hours' => 'integer',
        'due_date' => 'date',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}
