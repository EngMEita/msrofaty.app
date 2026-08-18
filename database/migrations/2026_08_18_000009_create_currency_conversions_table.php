<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::create('currency_conversions', function (Blueprint $table) { $table->id(); $table->foreignId('household_id')->constrained()->cascadeOnDelete(); $table->foreignId('from_account_id')->constrained('accounts')->restrictOnDelete(); $table->foreignId('to_account_id')->constrained('accounts')->restrictOnDelete(); $table->foreignId('from_currency_id')->constrained('currencies')->restrictOnDelete(); $table->foreignId('to_currency_id')->constrained('currencies')->restrictOnDelete(); $table->decimal('from_amount', 18, 2); $table->decimal('rate', 18, 8); $table->decimal('to_amount', 18, 2); $table->date('date'); $table->text('note')->nullable(); $table->timestamps(); }); }
    public function down(): void { Schema::dropIfExists('currency_conversions'); }
};
