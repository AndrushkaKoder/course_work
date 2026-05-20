<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CreditApplication\CreditApplicationStatus;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $client_id
 * @property int|null $user_id
 * @property int $sum
 * @property string|null $percent
 * @property array<array-key, mixed>|null $files
 * @property CreditApplicationStatus|null $status
 * @property string|null $cancel_reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Client $client
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication query()
 *
 * @mixin \Eloquent
 */
class CreditApplication extends Model
{
    use Fileable;

    protected $fillable = [
        'client_id',
        'user_id',
        'sum',
        'percent',
        'files',
        'status',
        'cancel_reason',
    ];

    protected $casts = [
        'status' => CreditApplicationStatus::class,
        'files' => 'array',
        'percent' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function formattedSum(): string
    {
        return number_format($this->sum, 0, ',', ' ').' ₽';
    }

    public function formattedPercent(): string
    {
        if ($this->percent === null) {
            return '—';
        }

        return number_format((float) $this->percent, 2, ',', ' ').' %';
    }
}
