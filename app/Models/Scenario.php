<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scenario extends Model
{
    use HasFactory, HasUlids;

    public const STATUS_DRAFT = 'DRAFT';
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_ARCHIVED = 'ARCHIVED';

    protected $fillable = [
        'family_id',
        'name',
        'start_date',
        'end_date',
        'status',
        'cloned_from_scenario_id',
        'created_by_user_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(BudgetLine::class);
    }

    public function clonedFrom(): BelongsTo
    {
        return $this->belongsTo(self::class, 'cloned_from_scenario_id');
    }
}
