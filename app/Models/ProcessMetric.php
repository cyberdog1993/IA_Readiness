<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessMetric extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'process_id',
        'name',
        'min_quantity',
        'avg_quantity',
        'max_quantity',
        'unit',
        'period',
        'source',
        'confirmed',
    ];

    protected $casts = [
        'min_quantity' => 'integer',
        'avg_quantity' => 'integer',
        'max_quantity' => 'integer',
        'confirmed' => 'boolean',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}
