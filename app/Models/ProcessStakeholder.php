<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessStakeholder extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'process_id',
        'name',
        'position',
        'area',
        'role',
        'participation_type',
        'email',
        'phone',
        'notes',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}
