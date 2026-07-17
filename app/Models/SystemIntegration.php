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
        'description',
        'has_api',
        'api_available',
        'api_type',
        'api_version',
        'documentation_url',
        'webhooks_available',
        'known_limits',
        'environment',
        'auth_type',
        'access_owner',
        'access_status',
        'access_status_detail',
        'restrictions',
        'notes',
    ];

    protected $casts = [
        'has_api' => 'boolean',
        'webhooks_available' => 'boolean',
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
