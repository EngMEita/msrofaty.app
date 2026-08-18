<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::create('currencies', function (Blueprint $table) { $table->id(); $table->foreignId('household_id')->constrained()->cascadeOnDelete(); $table->string('code', 3); $table->string('name'); $table->string('symbol', 8)->nullable(); $table->boolean('is_base')->default(false); $table->boolean('active')->default(true); $table->timestamps(); $table->unique(['household_id','code']); }); }
    public function down(): void { Schema::dropIfExists('currencies'); }
};
