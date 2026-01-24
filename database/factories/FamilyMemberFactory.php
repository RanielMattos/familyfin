<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FamilyMember>
 */
class FamilyMemberFactory extends Factory
{
    protected $model = FamilyMember::class;

    public function definition(): array
    {
        return [
            'family_id' => Family::factory(),
            'user_id' => User::factory(),
            'role' => FamilyMember::ROLE_MEMBER,
            'is_active' => true,
            'joined_at' => now(),
        ];
    }

    public function owner(): self
    {
        return $this->state(fn () => ['role' => FamilyMember::ROLE_OWNER]);
    }

    public function admin(): self
    {
        return $this->state(fn () => ['role' => FamilyMember::ROLE_ADMIN]);
    }

    public function viewer(): self
    {
        return $this->state(fn () => ['role' => FamilyMember::ROLE_VIEWER]);
    }
}
