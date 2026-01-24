<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxonomyNode extends Model
{
    use HasFactory, HasUlids;

    public const TYPE_GROUP = 'GROUP';
    public const TYPE_CATEGORY = 'CATEGORY';
    public const TYPE_SUBCATEGORY = 'SUBCATEGORY';
    public const TYPE_TAG = 'TAG';

    public const TYPES = [
        self::TYPE_GROUP,
        self::TYPE_CATEGORY,
        self::TYPE_SUBCATEGORY,
        self::TYPE_TAG,
    ];

    public const DIR_INCOME = 'INCOME';
    public const DIR_EXPENSE = 'EXPENSE';
    public const DIR_BOTH = 'BOTH';

    public const DIRECTIONS = [
        self::DIR_INCOME,
        self::DIR_EXPENSE,
        self::DIR_BOTH,
    ];

    protected $fillable = [
        'family_id',
        'parent_id',
        'type',
        'direction',
        'name',
        'slug',
        'sort_order',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }
}
