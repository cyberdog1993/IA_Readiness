<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'lead_id',
        'business_name',
        'ruc',
        'industry',
        'address',
        'main_contact',
        'contact_role',
        'email',
        'phone',
        'status',
        'notes',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function processes(): HasMany
    {
        return $this->hasMany(ProcessModel::class);
    }
}

