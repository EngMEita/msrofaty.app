<?php

namespace Tests\Unit;

use App\Models\Budget;
use App\Models\Entry;
use App\Models\Record;
use App\Models\User;
use App\Models\Account;
use App\Policies\BudgetPolicy;
use App\Policies\EntryPolicy;
use App\Policies\RecordPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationPoliciesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $otherUser;
    protected $entryPolicy;
    protected $budgetPolicy;
    protected $recordPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();
        $this->entryPolicy = new EntryPolicy();
        $this->budgetPolicy = new BudgetPolicy();
        $this->recordPolicy = new RecordPolicy();
    }

    public function test_entry_policy_allows_owner_to_view()
    {
        $entry = Entry::factory()->create(['user_id' => $this->user->id]);

        $this->assertTrue($this->entryPolicy->view($this->user, $entry));
    }

    public function test_entry_policy_prevents_non_owner_from_viewing()
    {
        $entry = Entry::factory()->create(['user_id' => $this->otherUser->id]);

        $this->assertFalse($this->entryPolicy->view($this->user, $entry));
    }

    public function test_entry_policy_allows_owner_to_update()
    {
        $entry = Entry::factory()->create(['user_id' => $this->user->id]);

        $this->assertTrue($this->entryPolicy->update($this->user, $entry));
    }

    public function test_entry_policy_prevents_non_owner_from_updating()
    {
        $entry = Entry::factory()->create(['user_id' => $this->otherUser->id]);

        $this->assertFalse($this->entryPolicy->update($this->user, $entry));
    }

    public function test_budget_policy_allows_owner_to_view()
    {
        $budget = Budget::factory()->create(['user_id' => $this->user->id]);

        $this->assertTrue($this->budgetPolicy->view($this->user, $budget));
    }

    public function test_budget_policy_prevents_non_owner_from_viewing()
    {
        $budget = Budget::factory()->create(['user_id' => $this->otherUser->id]);

        $this->assertFalse($this->budgetPolicy->view($this->user, $budget));
    }

    public function test_record_policy_allows_owner_to_view()
    {
        $entry = Entry::factory()->create(['user_id' => $this->user->id]);
        $account = Account::create(['name' => 'Test']);
        $record = Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => 1,
            'value' => 100,
        ]);

        $this->assertTrue($this->recordPolicy->view($this->user, $record));
    }

    public function test_record_policy_prevents_non_owner_from_viewing()
    {
        $entry = Entry::factory()->create(['user_id' => $this->otherUser->id]);
        $account = Account::create(['name' => 'Test']);
        $record = Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => 1,
            'value' => 100,
        ]);

        $this->assertFalse($this->recordPolicy->view($this->user, $record));
    }
}
