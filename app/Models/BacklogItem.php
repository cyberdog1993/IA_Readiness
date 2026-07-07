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
        'type',
        'title',
        'description',
        'acceptance_criteria',
        'priority',
        'responsible',
        'status',
        'estimated_hours',
    ];

    protected $casts = [
        'estimated_hours' => 'integer',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}

