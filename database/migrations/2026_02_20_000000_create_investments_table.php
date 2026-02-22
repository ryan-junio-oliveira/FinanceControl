<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('investments')) {
            Schema::create('investments', function (Blueprint $table) {
                $table->id();

                $table->foreignId('organization_id')
                    ->constrained()
                    ->restrictOnDelete();

                $table->string('name');
                $table->decimal('amount', 12, 2);
                $table->boolean('fixed')->default(false);
                $table->date('transaction_date')->nullable();

                $table->foreignId('monthly_financial_control_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->timestamps();

                $table->index(['organization_id', 'transaction_date']);
                $table->index('fixed');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};