<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillOccurrence extends Model
{
    use HasFactory, HasUlids;

    public const STATUS_OPEN = 'OPEN';
    public const STATUS_PAID = 'PAID';
    public const STATUS_LATE = 'LATE';
    public const STATUS_CANCELED = 'CANCELED';

    protected $fillable = [
        'bill_id',
        'competence',
        'due_date',
        'installment_number',
        'planned_amount_cents',
        'paid_amount_cents',
        'status',
        'paid_at',
        'external_ref',
        'notes',
    ];

    protected $casts = [
        'competence' => 'date',
        'due_date' => 'date',
        'installment_number' => 'integer',
        'planned_amount_cents' => 'integer',
        'paid_amount_cents' => 'integer',
        'paid_at' => 'date',
    ];

    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }
}
