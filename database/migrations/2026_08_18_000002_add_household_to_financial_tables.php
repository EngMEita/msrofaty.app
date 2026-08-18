<?php

use App\Models\Household;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        foreach (['accounts', 'categories', 'entries', 'records', 'budgets'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->foreignId('household_id')->nullable()->after('id')->constrained()->nullOnDelete();
                $blueprint->index('household_id');
            });
        }

        foreach (User::query()->get() as $user) {
            $household = Household::create(['name' => $user->name . ' Family']);
            $household->users()->attach($user->id, ['role' => 'owner']);
            DB::table('entries')->where('user_id', $user->id)->update(['household_id' => $household->id]);
            DB::table('budgets')->where('user_id', $user->id)->update(['household_id' => $household->id]);
        }

        $fallback = Household::query()->first();
        if ($fallback) {
            DB::table('accounts')->whereNull('household_id')->update(['household_id' => $fallback->id]);
            DB::table('categories')->whereNull('household_id')->update(['household_id' => $fallback->id]);
        }

        DB::table('records')->whereNull('household_id')->update([
            'household_id' => DB::raw('(select household_id from entries where entries.id = records.entry_id)'),
        ]);
    }

    public function down(): void
    {
        foreach (['accounts', 'categories', 'entries', 'records', 'budgets'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropConstrainedForeignId('household_id');
            });
        }
    }
};
