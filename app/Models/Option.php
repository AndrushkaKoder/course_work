<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property int $price
 * @property string $preview
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Sail> $sails
 * @property-read int|null $sails_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Option whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Option extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'id',
        'title',
        'price',
        'count',
    ];

    public function sails(): BelongsToMany
    {
        return $this->belongsToMany(
            Sail::class,
            'option_sale',
            'option_id',
            'sail_id'
        );
    }
}
