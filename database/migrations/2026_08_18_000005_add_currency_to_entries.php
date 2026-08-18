<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->string('currency', 3)->default('SAR')->after('total_amount');
        });
    }

    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) { $table->dropColumn('currency'); });
    }
};
