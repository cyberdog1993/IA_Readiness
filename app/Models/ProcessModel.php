<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessModel extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $table = 'processes';

    protected $fillable = [
        'lead_id',
        'client_id',
        'name',
        'area',
        'owner',
        'frequency',
        'objective',
        'expected_result',
        'trigger_event',
        'validation_method',
        'status',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(ProcessStep::class, 'process_id')->orderBy('step_number');
    }

    public function systems(): HasMany
    {
        return $this->hasMany(SystemIntegration::class, 'process_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(DocumentEvidence::class, 'process_id');
    }

    public function problems(): HasMany
    {
        return $this->hasMany(CurrentProblem::class, 'process_id');
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(AutomationOpportunity::class, 'process_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(InternalEvaluation::class, 'process_id');
    }

    public function backlogItems(): HasMany
    {
        return $this->hasMany(BacklogItem::class, 'process_id');
    }
}
