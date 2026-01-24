<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Family extends Model
{
    use HasUlids;
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'created_by_user_id',
        'currency',
        'timezone',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
    public function scenarios(): HasMany
    {
    return $this->hasMany(Scenario::class)->orderBy('start_date');
    }
    public function bills(): HasMany
    {
    return $this->hasMany(Bill::class)->orderBy('sort_order')->orderBy('name');
    }


}
