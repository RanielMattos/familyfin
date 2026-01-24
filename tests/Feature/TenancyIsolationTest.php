<?php

namespace Tests\Feature;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenancyIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_only_sees_own_families_via_relationship(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $familyA = Family::factory()->create(['created_by_user_id' => $userA->id]);
        $familyB = Family::factory()->create(['created_by_user_id' => $userB->id]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $familyA->id,
            'user_id' => $userA->id,
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $familyB->id,
            'user_id' => $userB->id,
        ]);

        $this->assertCount(1, $userA->families()->get());
        $this->assertEquals($familyA->id, $userA->families()->first()->id);

        $this->assertCount(1, $userB->families()->get());
        $this->assertEquals($familyB->id, $userB->families()->first()->id);

        // Anti-vazamento explícito
        $this->assertFalse($userA->families()->whereKey($familyB->id)->exists());
        $this->assertFalse($userB->families()->whereKey($familyA->id)->exists());
    }
}
