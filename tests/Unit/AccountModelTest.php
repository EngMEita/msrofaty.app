<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\Entry;
use App\Models\Record;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_balance_calculation_with_deposits()
    {
        $account = Account::create(['name' => 'Test Account']);
        $user = User::factory()->create();
        $entry = Entry::factory()->create(['user_id' => $user->id]);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => 1, // deposit
            'value' => 100,
        ]);

        $this->assertEquals(100, $account->balance);
    }

    public function test_account_balance_calculation_with_withdrawals()
    {
        $account = Account::create(['name' => 'Test Account']);
        $user = User::factory()->create();
        $entry = Entry::factory()->create(['user_id' => $user->id]);

        Record::create([
            'entry_id' => $entry->id,
            'account_id' => $account->id,
            'type' => -1, // withdrawal
            'value' => 50,
        ]);

        $this->assertEquals(-50, $account->balance);
    }

    public function test_account_balance_calculation_mixed()
    {
        $account = Account::create(['name' => 'Test Account']);
        $user = User::factory()->create();
        $entry = Entry::factory()->create(['user_id' => $user->id]);

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
            'value' => 30,
        ]);

        $this->assertEquals(70, $account->balance);
    }
}
