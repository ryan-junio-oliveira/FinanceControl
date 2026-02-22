<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete();
                
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->boolean('fixed')->default(false);
            $table->date('transaction_date')->nullable();

            $table->unsignedBigInteger('monthly_financial_control_id');
            $table->timestamps();

            $table->foreign('monthly_financial_control_id')->references('id')->on('monthly_financial_controls')->onDelete('cascade');

            $table->index('organization_id');
            $table->index('category_id');
            $table->index('monthly_financial_control_id');
            $table->index('name');
            $table->index('fixed');
            $table->index('transaction_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
 