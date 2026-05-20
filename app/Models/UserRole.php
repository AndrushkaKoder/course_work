<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, User> $users
 */
class UserRole extends Model
{
    final public const int ADMIN_ID = 1;

    final public const int MANAGER_ID = 2;

    protected $table = 'user_roles';

    protected $fillable = [
        'name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
