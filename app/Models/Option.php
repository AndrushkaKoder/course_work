<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
