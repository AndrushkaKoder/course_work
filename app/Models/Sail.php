<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Sail\SailStatus;
use App\Enums\Sail\SailType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $client_id
 * @property int|null $user_id
 * @property int|null $car_id
 * @property int|null $price
 * @property SailStatus $status
 * @property SailType $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Car|null $car
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereUserId($value)
 * @mixin \Eloquent
 */
class Sail extends Model
{
    protected $table = 'sails';

    protected $fillable = [
        'client_id',
        'user_id',
        'car_id',
        'price',
        'status',
        'type',
    ];

    protected $casts = [
        'status' => SailStatus::class,
        'type' => SailType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
