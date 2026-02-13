<?php

namespace Tests\Feature;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FamilyMembersFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_any_member_can_view_members_page(): void
    {
        $family = Family::factory()->create();

        $user = User::factory()->create();
        FamilyMember::factory()->create([
            'family_id' => $family->id,
            'user_id' => $user->id,
            'role' => FamilyMember::ROLE_MEMBER,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('family.members.index', ['family' => $family->id]))
            ->assertStatus(200);
    }

    public function test_only_owner_or_admin_can_add_member(): void
    {
        $family = Family::factory()->create();

        $owner = User::factory()->create();
        FamilyMember::factory()->create([
            'family_id' => $family->id,
            'user_id' => $owner->id,
            'role' => FamilyMember::ROLE_OWNER,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        $target = User::factory()->create();

        $this->actingAs($owner)
            ->post(route('family.members.store', ['family' => $family->id]), [
                'email' => $target->email,
                'role' => FamilyMember::ROLE_MEMBER,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('family_members', [
            'family_id' => $family->id,
            'user_id' => $target->id,
        ]);

        // member comum não pode
        $member = User::factory()->create();
        FamilyMember::factory()->create([
            'family_id' => $family->id,
            'user_id' => $member->id,
            'role' => FamilyMember::ROLE_MEMBER,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        $this->actingAs($member)
            ->post(route('family.members.store', ['family' => $family->id]), [
                'email' => User::factory()->create()->email,
                'role' => FamilyMember::ROLE_MEMBER,
            ])
            ->assertStatus(403);
    }

    public function test_cannot_remove_last_owner(): void
    {
        $family = Family::factory()->create();

        $owner = User::factory()->create();
        $ownerMembership = FamilyMember::factory()->create([
            'family_id' => $family->id,
            'user_id' => $owner->id,
            'role' => FamilyMember::ROLE_OWNER,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        $admin = User::factory()->create();
        FamilyMember::factory()->create([
            'family_id' => $family->id,
            'user_id' => $admin->id,
            'role' => FamilyMember::ROLE_ADMIN,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        $this->actingAs($admin)
            ->delete(route('family.members.destroy', ['family' => $family->id, 'member' => $ownerMembership->id]))
            ->assertRedirect();

        $this->assertDatabaseHas('family_members', [
            'id' => $ownerMembership->id,
            'family_id' => $family->id,
            'user_id' => $owner->id,
        ]);
    }

    public function test_scope_bindings_prevents_cross_family_member_access(): void
    {
        $user = User::factory()->create();

        $familyA = Family::factory()->create();
        $familyB = Family::factory()->create();

        $memberA = FamilyMember::factory()->create([
            'family_id' => $familyA->id,
            'user_id' => $user->id,
            'role' => FamilyMember::ROLE_OWNER,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        FamilyMember::factory()->create([
            'family_id' => $familyB->id,
            'user_id' => $user->id,
            'role' => FamilyMember::ROLE_OWNER,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        $this->actingAs($user)
            ->put(route('family.members.update', ['family' => $familyB->id, 'member' => $memberA->id]), [
                'role' => FamilyMember::ROLE_MEMBER,
            ])
            ->assertNotFound();
    }
}
