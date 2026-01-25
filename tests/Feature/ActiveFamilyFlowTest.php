<?php

namespace Tests\Feature;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActiveFamilyFlowTest extends TestCase
{
    use RefreshDatabase;

    private function attach(User $user, Family $family, bool $active = false, string $role = 'owner'): void
    {
        FamilyMember::create([
            'family_id'  => $family->id,
            'user_id'    => $user->id,
            'role'       => $role,
            'is_active'  => $active ? 1 : 0,
        ]);
    }

    public function test_activate_family_sets_it_active_and_deactivates_others(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $familyA = Family::factory()->create();
        $familyB = Family::factory()->create();

        $this->attach($user, $familyA, true);
        $this->attach($user, $familyB, false);

        $this->actingAs($user)
            ->post(route('families.activate', ['family' => $familyB->id]))
            ->assertRedirect();

        $this->assertDatabaseHas('family_members', [
            'family_id' => $familyB->id,
            'user_id'   => $user->id,
            'is_active' => 1,
        ]);

        $this->assertDatabaseHas('family_members', [
            'family_id' => $familyA->id,
            'user_id'   => $user->id,
            'is_active' => 0,
        ]);
    }

    public function test_dashboard_redirects_to_active_family_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $family = Family::factory()->create();
        $this->attach($user, $family, true);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect(route('family.dashboard', ['family' => $family->id]));
    }
}
