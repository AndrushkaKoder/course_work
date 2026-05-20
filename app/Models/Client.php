<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $passport_series
 * @property string|null $passport_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CreditApplication> $creditApplications
 * @property-read int|null $credit_applications_count
 * @property-read Collection<int, Sail> $sails
 * @property-read int|null $sails_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'phone',
        'passport_series',
        'passport_number',
    ];

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class, 'client_id');
    }

    public function sails(): HasMany
    {
        return $this->hasMany(Sail::class, 'client_id');
    }
}
