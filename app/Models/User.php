<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Family;
use App\Models\FamilyMember;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function familyMemberships(): HasMany
{
    return $this->hasMany(FamilyMember::class);
}

public function families(): BelongsToMany
{
    return $this->belongsToMany(Family::class, 'family_members')
        ->withPivot(['role', 'is_active', 'joined_at'])
        ->withTimestamps();
}

public function activeMembershipFor(Family|string $family): ?FamilyMember
{
    $familyId = $family instanceof Family ? $family->id : $family;

    return $this->familyMemberships()
        ->where('family_id', $familyId)
        ->where('is_active', true)
        ->first();
}

public function familyRoleFor(Family|string $family): ?string
{
    return $this->activeMembershipFor($family)?->role;
}

public function hasFamilyRole(Family|string $family, array|string $roles): bool
{
    $roles = (array) $roles;
    $role = $this->familyRoleFor($family);

    if (!$role) {
        return false;
    }

    // roles no banco estão em uppercase (OWNER/ADMIN/MEMBER/VIEWER)
    return in_array(strtoupper($role), array_map('strtoupper', $roles), true);
}
}
