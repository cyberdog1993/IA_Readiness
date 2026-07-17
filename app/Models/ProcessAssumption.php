<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessAssumption extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'process_id',
        'description',
        'impact',
        'validation_owner',
        'status',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}
