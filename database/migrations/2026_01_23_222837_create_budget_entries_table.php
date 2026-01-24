<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('budget_entries', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulid('budget_line_id');
            $table->foreign('budget_line_id')->references('id')->on('budget_lines')->cascadeOnDelete();

            /**
             * Competência: sempre o 1º dia do mês (YYYY-MM-01)
             */
            $table->date('competence');

            /**
             * Valor em centavos (evita float). Pode ser 0.
             */
            $table->bigInteger('amount_cents')->default(0);

            $table->timestamps();

            $table->index(['competence']);
            $table->unique(['budget_line_id', 'competence']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_entries');
    }
};
