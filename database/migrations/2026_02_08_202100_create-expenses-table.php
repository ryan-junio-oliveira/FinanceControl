<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ensure the table does not exist yet and dependencies are available
        if (! Schema::hasTable('expenses')) {
            Schema::create('expenses', function (Blueprint $table) {
                $table->id();

                $table->foreignId('organization_id')
                    ->constrained()
                    ->restrictOnDelete();

                $table->foreignId('category_id')
                    ->constrained()
                    ->restrictOnDelete();

                $table->string('name');
                $table->decimal('amount', 12, 2);
                $table->boolean('fixed')->default(false);
                $table->date('transaction_date')->nullable();

                // novos campos para controlar pagamento
                $table->boolean('paid')->default(false);
                $table->date('paid_at')->nullable();

                $table->foreignId('monthly_financial_control_id')
                    ->constrained()
                    ->cascadeOnDelete(); // aqui pode manter

                $table->timestamps();

                $table->index(['organization_id', 'transaction_date']);
                $table->index('category_id');
                $table->index('fixed');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
