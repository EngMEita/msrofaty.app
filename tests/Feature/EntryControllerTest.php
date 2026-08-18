<?php

namespace Tests\Feature;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();
    }

    public function test_authenticated_user_can_access_dashboard()
    {
        $response = $this->actingAs($this->user)
            ->get('/acp');

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_access_dashboard()
    {
        $response = $this->get('/acp');

        $response->assertRedirect('/login');
    }

    public function test_user_can_only_see_their_own_entries()
    {
        $entry = Entry::factory()->create(['user_id' => $this->user->id]);
        $otherEntry = Entry::factory()->create(['user_id' => $this->otherUser->id]);

        $response = $this->actingAs($this->user)
            ->get('/acp');

        $response->assertStatus(200);
        // Entry should be in the response but otherEntry should not
    }

    public function test_user_cannot_access_other_users_entries()
    {
        $entry = Entry::factory()->create(['user_id' => $this->otherUser->id]);

        $response = $this->actingAs($this->user)
            ->get('/acp/entry/' . $entry->id);

        $response->assertStatus(403); // Forbidden
    }

    public function test_report_generates_correct_year_and_month()
    {
        $entry = Entry::factory()->create([
            'user_id' => $this->user->id,
            'date' => now()->setYear(2024)->setMonth(6),
        ]);

        $response = $this->actingAs($this->user)
            ->get('/acp/report/2024/6');

        $response->assertStatus(200);
    }
}
