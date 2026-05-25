<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Sail\SailStatus;
use App\Enums\Sail\SailType;
use App\Support\MoneyFormat;
use App\Traits\Fileable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $client_id
 * @property int|null $user_id
 * @property int|null $car_id
 * @property int|null $price
 * @property SailStatus $status
 * @property SailType $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array<array-key, mixed>|null $files
 * @property-read Car|null $car
 * @property-read Client|null $client
 * @property-read Collection<int, Option> $options
 * @property-read int|null $options_count
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereUserId($value)
 *
 * @mixin Eloquent
 */
class Sail extends Model
{
    use Fileable;

    protected $table = 'sails';

    protected $fillable = [
        'client_id',
        'user_id',
        'car_id',
        'price',
        'status',
        'type',
        'files',
    ];

    protected $casts = [
        'status' => SailStatus::class,
        'type' => SailType::class,
        'files' => 'array',
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

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(
            Option::class,
            'option_sale',
            'sail_id',
            'option_id'
        );
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function formattedPrice(): string
    {
        return MoneyFormat::format($this->price);
    }
}
