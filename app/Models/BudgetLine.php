<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetLine extends Model
{
    use HasFactory, HasUlids;

    public const DIR_INCOME = 'INCOME';
    public const DIR_EXPENSE = 'EXPENSE';

    public const NATURE_FIXED = 'FIXED';
    public const NATURE_VARIABLE = 'VARIABLE';
    public const NATURE_ONE_OFF = 'ONE_OFF';

    public const VIS_FAMILY = 'FAMILY';
    public const VIS_ADULTS = 'ADULTS';
    public const VIS_OWNER = 'OWNER';

    protected $fillable = [
        'family_id',
        'scenario_id',
        'direction',
        'group_node_id',
        'category_node_id',
        'subcategory_node_id',
        'name',
        'nature',
        'visibility',
        'is_active',
        'slug',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(Scenario::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(BudgetEntry::class)->orderBy('competence');
    }

    public function groupNode(): BelongsTo
    {
        return $this->belongsTo(TaxonomyNode::class, 'group_node_id');
    }

    public function categoryNode(): BelongsTo
    {
        return $this->belongsTo(TaxonomyNode::class, 'category_node_id');
    }

    public function subcategoryNode(): BelongsTo
    {
        return $this->belongsTo(TaxonomyNode::class, 'subcategory_node_id');
    }
}
