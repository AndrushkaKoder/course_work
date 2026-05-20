<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPermission extends Model
{
    protected $table = 'user_permissions';

    protected $fillable = [
        'user_id',
        'permissions',
    ];

    protected function casts(): array
    {
        return [
            'permissions' => 'collection',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
