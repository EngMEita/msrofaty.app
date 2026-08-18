<?php

namespace Tests\Unit;

use App\Models\Entry;
use App\Models\Record;
use App\Models\User;
use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_entry_status_is_balanced_when_deposit_equals_withdrawal()
    {
        $user = User::factory()->create();
        $entry = Entry::factory()->create(['user_id' => $user->id]);
        $account = Account::create(['name' => 'Test Account']);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => 1, // deposit
            'value' => 100,
        ]);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => -1, // withdrawal
            'value' => 100,
        ]);

        $this->assertTrue($entry->status);
    }

    public function test_entry_status_is_unbalanced_when_deposit_not_equals_withdrawal()
    {
        $user = User::factory()->create();
        $entry = Entry::factory()->create(['user_id' => $user->id]);
        $account = Account::create(['name' => 'Test Account']);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => 1, // deposit
            'value' => 100,
        ]);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => -1, // withdrawal
            'value' => 50,
        ]);

        $this->assertFalse($entry->status);
    }

    public function test_entry_withdraw_attribute_calculates_correctly()
    {
        $user = User::factory()->create();
        $entry = Entry::factory()->create(['user_id' => $user->id]);
        $account = Account::create(['name' => 'Test Account']);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => -1, // withdrawal
            'value' => 50,
        ]);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => -1, // withdrawal
            'value' => 30,
        ]);

        $this->assertEquals(80, $entry->withdraw);
    }

    public function test_entry_deposit_attribute_calculates_correctly()
    {
        $user = User::factory()->create();
        $entry = Entry::factory()->create(['user_id' => $user->id]);
        $account = Account::create(['name' => 'Test Account']);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => 1, // deposit
            'value' => 50,
        ]);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => 1, // deposit
            'value' => 30,
        ]);

        $this->assertEquals(80, $entry->deposit);
    }
}
