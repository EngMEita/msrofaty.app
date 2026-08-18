<?php

namespace Tests\Unit;

use App\Models\Entry;
use App\Models\Household;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HouseholdAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_family_members_can_view_the_same_entry(): void
    {
        [$owner, $member, $household] = $this->family();
        $entry = Entry::factory()->create([
            'user_id' => $owner->id,
            'household_id' => $household->id,
        ]);

        $this->assertTrue($owner->can('view', $entry));
        $this->assertTrue($member->can('view', $entry));
    }

    public function test_members_of_another_family_cannot_view_an_entry(): void
    {
        [$owner, , $household] = $this->family();
        $outsider = User::factory()->create();
        $otherHousehold = Household::factory()->create();
        $otherHousehold->users()->attach($outsider, ['role' => 'owner']);
        $entry = Entry::factory()->create([
            'user_id' => $owner->id,
            'household_id' => $household->id,
        ]);

        $this->assertFalse($outsider->can('view', $entry));
    }

    private function family(): array
    {
        $owner = User::factory()->create();
        $member = User::factory()->create();
        $household = Household::factory()->create();
        $household->users()->attach([
            $owner->id => ['role' => 'owner'],
            $member->id => ['role' => 'editor'],
        ]);

        return [$owner, $member, $household];
    }
}
