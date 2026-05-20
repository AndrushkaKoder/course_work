<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Car\CarType;
use App\Traits\Fileable;
use App\Traits\HasPreview;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $mark
 * @property string $model
 * @property string|null $class
 * @property string $vin_code
 * @property int $year
 * @property int $price
 * @property string $color
 * @property CarType $type
 * @property int $count
 * @property string|null $state_number
 * @property string|null $preview
 * @property string|null $images
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $mileage
 *
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereMileage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereStateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereVinCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereYear($value)
 *
 * @mixin Eloquent
 */
class Car extends Model
{
    use Fileable;
    use HasPreview;

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
        'files',
        'mileage',
    ];

    protected $casts = [
        'type' => CarType::class,
        'files' => 'array',
    ];

    public function getViewName(): string
    {
        return "{$this->mark} {$this->model} {$this->year}";
    }

    public function getCarSailInfo(): string
    {
        $type = $this->type == CarType::USED ? 'Б/У' : 'Новый';

        return "{$this->id} | {$this->mark} {$this->model} | {$this->year} | {$type}";
    }

    public function getViewPrice(): string
    {
        return "$this->price P";
    }
}
