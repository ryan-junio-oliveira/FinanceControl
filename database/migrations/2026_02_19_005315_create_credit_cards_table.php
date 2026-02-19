<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')
                ->constrained()
                ->cascadeOnDelete();

            // Obrigatórios
            $table->string('name');
            $table->string('bank');
            $table->decimal('statement_amount', 12, 2);

            // Opcionais
            $table->decimal('limit', 12, 2)->nullable();
            $table->unsignedTinyInteger('closing_day')->nullable();     // 1-31
            $table->unsignedTinyInteger('due_day')->nullable();         // 1-31
            $table->boolean('is_active')->default(true);
            $table->string('color')->nullable();

            $table->timestamps();

            // Índice para multi-tenant
            $table->index(['organization_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
