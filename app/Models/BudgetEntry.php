<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetEntry extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'budget_line_id',
        'competence',
        'amount_cents',
    ];

    protected $casts = [
        'competence' => 'date',
        'amount_cents' => 'integer',
    ];

    public function line(): BelongsTo
    {
        return $this->belongsTo(BudgetLine::class, 'budget_line_id');
    }
}
