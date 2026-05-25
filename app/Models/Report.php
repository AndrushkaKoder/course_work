<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Report\ReportStatus;
use App\Enums\Sail\SailType;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $user_id
 * @property Carbon $from
 * @property Carbon $to
 * @property SailType $type
 * @property ReportStatus $status
 * @property string|null $file
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @mixin Eloquent
 */
class Report extends Model
{
    protected $fillable = [
        'user_id',
        'from',
        'to',
        'type',
        'status',
        'file',
    ];

    protected $casts = [
        'from' => 'date',
        'to' => 'date',
        'type' => SailType::class,
        'status' => ReportStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formattedPeriod(): string
    {
        return $this->from->format('d.m.Y').' — '.$this->to->format('d.m.Y');
    }

    public function formattedType(): string
    {
        return SailType::values()[$this->type->value] ?? $this->type->name;
    }
}
