<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) { $table->boolean('platform_admin')->default(false)->after('password'); });
        Schema::table('households', function (Blueprint $table) { $table->foreignId('owner_id')->nullable()->after('id')->constrained('users')->nullOnDelete(); $table->string('status', 20)->default('active'); });
        Schema::create('plans', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->decimal('price', 10, 2)->default(0); $table->string('billing_period', 20)->default('monthly');
            $table->unsignedInteger('max_members')->nullable(); $table->unsignedInteger('max_accounts')->nullable(); $table->unsignedInteger('max_transactions')->nullable(); $table->boolean('active')->default(true); $table->timestamps();
        });
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id(); $table->foreignId('household_id')->constrained()->cascadeOnDelete(); $table->foreignId('plan_id')->constrained()->restrictOnDelete(); $table->string('status', 20)->default('trial');
            $table->timestamp('starts_at')->nullable(); $table->timestamp('ends_at')->nullable(); $table->timestamp('trial_ends_at')->nullable(); $table->timestamps();
        });
        $free = DB::table('plans')->insertGetId(['name' => 'Free', 'price' => 0, 'billing_period' => 'monthly', 'max_members' => 2, 'max_accounts' => 5, 'max_transactions' => 500, 'active' => true, 'created_at' => now(), 'updated_at' => now()]);
        $firstUser = DB::table('users')->orderBy('id')->value('id');
        if ($firstUser) { DB::table('users')->where('id', $firstUser)->update(['platform_admin' => true]); }
        DB::table('households')->orderBy('id')->get()->each(function ($household) use ($free) {
            DB::table('households')->where('id', $household->id)->update(['owner_id' => DB::table('household_user')->where('household_id', $household->id)->where('role', 'owner')->value('user_id')]);
            DB::table('subscriptions')->insert(['household_id' => $household->id, 'plan_id' => $free, 'status' => 'trial', 'starts_at' => now(), 'trial_ends_at' => now()->addDays(14), 'created_at' => now(), 'updated_at' => now()]);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('subscriptions'); Schema::dropIfExists('plans'); Schema::table('households', function (Blueprint $table) { $table->dropConstrainedForeignId('owner_id'); $table->dropColumn('status'); }); Schema::table('users', function (Blueprint $table) { $table->dropColumn('platform_admin'); });
    }
};
