<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemIntegration extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $table = 'system_integrations';

    protected $fillable = [
        'client_id',
        'process_id',
        'name',
        'url',
        'system_type',
        'has_api',
        'auth_type',
        'access_owner',
        'access_status',
        'notes',
    ];

    protected $casts = [
        'has_api' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessModel::class, 'process_id');
    }
}

