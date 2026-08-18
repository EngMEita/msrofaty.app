<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::create('exchange_rates', function (Blueprint $table) { $table->id(); $table->foreignId('household_id')->constrained()->cascadeOnDelete(); $table->foreignId('from_currency_id')->constrained('currencies')->cascadeOnDelete(); $table->foreignId('to_currency_id')->constrained('currencies')->cascadeOnDelete(); $table->decimal('rate', 18, 8); $table->date('effective_on'); $table->timestamps(); $table->index(['household_id','from_currency_id','to_currency_id','effective_on'], 'ex_rate_lookup_idx'); }); }
    public function down(): void { Schema::dropIfExists('exchange_rates'); }
};
