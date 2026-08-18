<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Category;
use App\Models\Household;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class SetupPlatform extends Command
{
    protected $signature = 'platform:setup
        {--email= : Platform owner email}
        {--name= : Platform owner name}
        {--password= : Platform owner password}
        {--household= : Default household name}';

    protected $description = 'Create or update the platform owner, free plan, household, and starter data';

    public function handle(): int
    {
        foreach (['users', 'households', 'plans', 'subscriptions'] as $table) {
            if (! Schema::hasTable($table)) {
                $this->error("Table [{$table}] is missing. Run php artisan migrate first.");
                return self::FAILURE;
            }
        }

        $email = $this->option('email') ?: $this->ask('Platform owner email', 'admin@example.com');
        $name = $this->option('name') ?: $this->ask('Platform owner name', 'Platform Owner');
        $password = $this->option('password') ?: $this->secret('Platform owner password');
        $householdName = $this->option('household') ?: $this->ask('Default household name', 'My Family');

        if (!$email || !$name || !$password || strlen($password) < 8) {
            $this->error('Email, name, and a password of at least 8 characters are required.');
            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $name;
        $user->platform_admin = true;
        // User::setPasswordAttribute hashes the value once.
        $user->password = $password;
        $user->email_verified_at = $user->email_verified_at ?: now();
        $user->save();

        $plan = Plan::updateOrCreate(['name' => 'Free'], [
            'price' => 0,
            'billing_period' => 'monthly',
            'max_members' => 2,
            'max_accounts' => 5,
            'max_transactions' => 500,
            'active' => true,
        ]);

        $household = Household::firstOrCreate(['owner_id' => $user->id], [
            'name' => $householdName,
            'status' => 'active',
        ]);
        $household->update(['name' => $household->name ?: $householdName, 'status' => 'active']);
        $household->users()->syncWithoutDetaching([$user->id => ['role' => 'owner']]);

        Subscription::updateOrCreate(['household_id' => $household->id], [
            'plan_id' => $plan->id,
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => null,
            'trial_ends_at' => null,
        ]);

        foreach (['Bank account', 'Cash wallet'] as $accountName) {
            Account::firstOrCreate(['household_id' => $household->id, 'name' => $accountName]);
        }
        foreach (['Food', 'Bills', 'Transport', 'Education', 'Health', 'Other'] as $categoryName) {
            Category::firstOrCreate(['household_id' => $household->id, 'name' => $categoryName], ['category_id' => null]);
        }

        $this->info('Platform setup completed successfully.');
        $this->line("Owner: {$user->email}");
        $this->line("Admin panel: /admin");
        $this->line("Family panel: /family");

        return self::SUCCESS;
    }
}
