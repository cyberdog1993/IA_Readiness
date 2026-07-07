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
        'current_time_minutes',
        'expected_time_minutes',
        'estimated_savings_minutes',
        'suggested_technology',
        'priority',
        'complexity',
        'status',
        'notes',
    ];

    protected $casts = [
        'current_time_minutes' => 'integer',
        'expected_time_minutes' => 'integer',
        'estimated_savings_minutes' => 'integer',
        'complexity' => 'integer',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}

