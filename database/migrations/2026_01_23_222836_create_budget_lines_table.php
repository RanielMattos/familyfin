<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('budget_lines', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulid('family_id');
            $table->foreign('family_id')->references('id')->on('families')->cascadeOnDelete();

            $table->ulid('scenario_id');
            $table->foreign('scenario_id')->references('id')->on('scenarios')->cascadeOnDelete();

            /**
             * Direção do orçamento:
             * INCOME | EXPENSE
             */
            $table->string('direction', 20);

            /**
             * Taxonomia (opcional na fase 0, mas já preparada).
             * Na UI você pode exigir, mas no banco deixo nullable para import progressivo.
             */
            $table->ulid('group_node_id')->nullable();
            $table->foreign('group_node_id')->references('id')->on('taxonomy_nodes')->nullOnDelete();

            $table->ulid('category_node_id')->nullable();
            $table->foreign('category_node_id')->references('id')->on('taxonomy_nodes')->nullOnDelete();

            $table->ulid('subcategory_node_id')->nullable();
            $table->foreign('subcategory_node_id')->references('id')->on('taxonomy_nodes')->nullOnDelete();

            /**
             * Nome da linha (ex: Salário, Aluguel, Internet).
             */
            $table->string('name', 140);

            /**
             * Natureza: FIXED | VARIABLE | ONE_OFF
             */
            $table->string('nature', 20)->default('FIXED');

            /**
             * Visibilidade: FAMILY | ADULTS | OWNER
             */
            $table->string('visibility', 20)->default('FAMILY');

            $table->boolean('is_active')->default(true);

            // ajuda no import/dedupe (nome normalizado)
            $table->string('slug', 180);

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['family_id', 'scenario_id', 'direction']);
            $table->index(['scenario_id', 'is_active']);
            $table->index(['group_node_id', 'category_node_id', 'subcategory_node_id']);

            // Unicidade dentro do cenário (evita duplicar a mesma linha por acidente)
            $table->unique(['scenario_id', 'direction', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_lines');
    }
};
