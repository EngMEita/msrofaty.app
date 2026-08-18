<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::table('entries', function (Blueprint $table) { $table->string('workflow_status', 20)->default('draft')->after('entry_type'); $table->string('reference_number', 40)->nullable()->unique()->after('workflow_status'); }); }
    public function down(): void { Schema::table('entries', function (Blueprint $table) { $table->dropUnique(['reference_number']); $table->dropColumn(['workflow_status','reference_number']); }); }
};
