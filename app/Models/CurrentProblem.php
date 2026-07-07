<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrentProblem extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $table = 'current_problems';

    protected $fillable = [
        'process_id',
        'description',
        'impact',
        'frequency',
        'risk',
        'comments',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}

