<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory, HasUlids;

    public const DIR_PAYABLE = 'PAYABLE';
    public const DIR_RECEIVABLE = 'RECEIVABLE';

    public const REC_NONE = 'NONE';
    public const REC_MONTHLY = 'MONTHLY';
    public const REC_WEEKLY = 'WEEKLY';
    public const REC_YEARLY = 'YEARLY';
    public const REC_CUSTOM = 'CUSTOM';

    protected $fillable = [
        'family_id',
        'scenario_id',
        'direction',
        'group_node_id',
        'category_node_id',
        'subcategory_node_id',
        'name',
        'slug',
        'recurrence',
        'day_of_month',
        'interval_days',
        'total_installments',
        'default_amount_cents',
        'is_active',
        'sort_order',
        'notes',
        'created_by_user_id',
    ];

    protected $casts = [
        'day_of_month' => 'integer',
        'interval_days' => 'integer',
        'total_installments' => 'integer',
        'default_amount_cents' => 'integer',
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

    public function occurrences(): HasMany
    {
        return $this->hasMany(BillOccurrence::class)->orderBy('due_date');
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
