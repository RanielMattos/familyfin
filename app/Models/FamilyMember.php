<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    use HasFactory, HasUlids;

    // Alinhado com a migration (uppercase)
    public const ROLE_OWNER  = 'OWNER';
    public const ROLE_ADMIN  = 'ADMIN';
    public const ROLE_MEMBER = 'MEMBER';
    public const ROLE_VIEWER = 'VIEWER';

    protected $table = 'family_members';

    protected $fillable = [
        'family_id',
        'user_id',
        'role',
        'is_active',
        'joined_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'joined_at' => 'datetime',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
