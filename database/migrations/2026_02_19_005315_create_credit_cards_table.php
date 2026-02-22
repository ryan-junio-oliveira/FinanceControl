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

            // bank_id requires banks table – the migration timestamp has been
            // adjusted so banks are created just before credit_cards.
            $table->foreignId('bank_id')
                ->constrained()
                ->cascadeOnDelete();

            // Obrigatórios
            $table->string('name');
            $table->string('bank');
            $table->decimal('statement_amount', 12, 2);

            // controle de pagamento da fatura atual
            $table->boolean('paid')->default(false);
            // (paid_at removed – transaction_date used instead)

            // Opcionais
            $table->decimal('limit', 12, 2)->nullable();
            $table->unsignedTinyInteger('closing_day')->nullable();     // 1-31
            $table->unsignedTinyInteger('due_day')->nullable();         // 1-31
            $table->boolean('is_active')->default(true);
            $table->string('color')->nullable();

            $table->timestamps();

            // Índice para multi-tenant (nome curto para não ultrapassar o limite de 64
            // caracteres do MySQL). o nome automático anterior era muito longo e
            // gerava erro 1059.
            $table->index(
                ['organization_id', 'is_active', 'closing_day', 'due_day', 'bank_id'],
                'cc_org_active_closing_due_bank_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
