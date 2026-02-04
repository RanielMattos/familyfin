<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'description',
        'amount',
        'received_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'received_at' => 'date',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
