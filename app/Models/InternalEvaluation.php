<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternalEvaluation extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $table = 'internal_evaluations';

    protected $fillable = [
        'process_id',
        'complexity',
        'risk',
        'impact',
        'requires_mcp',
        'requires_hermes_skill',
        'requires_n8n',
        'requires_ai',
        'requires_ocr',
        'estimated_hours',
        'technical_notes',
    ];

    protected $casts = [
        'complexity' => 'integer',
        'risk' => 'integer',
        'impact' => 'integer',
        'requires_mcp' => 'boolean',
        'requires_hermes_skill' => 'boolean',
        'requires_n8n' => 'boolean',
        'requires_ai' => 'boolean',
        'requires_ocr' => 'boolean',
        'estimated_hours' => 'integer',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}

