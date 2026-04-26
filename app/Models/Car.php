<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Car\CarColor;
use App\Enums\Car\CarType;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $mark
 * @property string $model
 * @property string|null $class
 * @property string $vin_code
 * @property int $year
 * @property int $price
 * @property CarColor $color
 * @property CarType $type
 * @property int $count
 * @property string|null $state_number
 * @property string|null $preview
 * @property string|null $images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereStateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereVinCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereYear($value)
 * @mixin \Eloquent
 */
class Car extends Model
{
    protected $table = 'cars';

    protected $fillable = [
        'mark',
        'model',
        'class',
        'vin_code',
        'year',
        'price',
        'color',
        'type',
        'count',
        'state_number',
        'preview',
        'images',
    ];

    protected $casts = [
        'color' => CarColor::class,
        'type' => CarType::class,
    ];
}
