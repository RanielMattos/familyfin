<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('scenarios', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulid('family_id');
            $table->foreign('family_id')->references('id')->on('families')->cascadeOnDelete();

            $table->string('name', 120); // ex: "2025-2026", "Base", "Otimista"
            $table->date('start_date');
            $table->date('end_date');

            // DRAFT | ACTIVE | ARCHIVED
            $table->string('status', 20)->default('DRAFT');

            // prepara comparação e “versões” futuramente
            $table->ulid('cloned_from_scenario_id')->nullable();
            $table->foreign('cloned_from_scenario_id')->references('id')->on('scenarios')->nullOnDelete();

            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['family_id', 'status']);
            $table->index(['family_id', 'start_date', 'end_date']);

            // evita nome duplicado dentro da família (pode ajustar depois, mas ajuda agora)
            $table->unique(['family_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scenarios');
    }
};
