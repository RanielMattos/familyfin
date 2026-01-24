<?php

namespace Tests\Feature;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FamilyAccessMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_access_family_route(): void
    {
        $user = User::factory()->create();
        $family = Family::factory()->create(['created_by_user_id' => $user->id]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->get("/f/{$family->id}/ping")
            ->assertOk()
            ->assertJson(['ok' => true]);
    }

    public function test_non_member_gets_403(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $family = Family::factory()->create(['created_by_user_id' => $userA->id]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id' => $userA->id,
        ]);

        $this->actingAs($userB)
            ->get("/f/{$family->id}/ping")
            ->assertForbidden();
    }
}
