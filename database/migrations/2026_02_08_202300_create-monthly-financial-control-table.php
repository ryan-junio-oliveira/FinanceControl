<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_financial_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('month'); // 1-12
            $table->integer('year');
            $table->timestamps();

            $table->unique(['organization_id', 'month', 'year']);
            $table->index('organization_id');
            $table->index('month');
            $table->index('year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_financial_controls');
    }
};
