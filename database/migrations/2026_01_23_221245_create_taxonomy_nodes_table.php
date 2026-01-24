<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('taxonomy_nodes', function (Blueprint $table) {
            $table->ulid('id')->primary();

            /**
             * Escopo: por padrão, taxonomia global (family_id = null).
             * No futuro, você pode permitir taxonomia custom por família
             * sem refazer o modelo.
             */
            $table->ulid('family_id')->nullable();
            $table->foreign('family_id')->references('id')->on('families')->cascadeOnDelete();

            /**
             * Hierarquia: grupo -> categoria -> subcategoria
             * tags podem ser "flat" (parent_id null) ou penduradas, você decide depois.
             */
            $table->ulid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('taxonomy_nodes')->cascadeOnDelete();

            /**
             * Tipos controlados (simples e rígido)
             * GROUP | CATEGORY | SUBCATEGORY | TAG
             */
            $table->string('type', 20);

            /**
             * Direção do dinheiro:
             * INCOME | EXPENSE | BOTH (útil para tags ou alguns agrupamentos)
             */
            $table->string('direction', 20)->default('BOTH');

            /**
             * Nome exibido (PT-BR) e slug estável pra import/dedupe.
             */
            $table->string('name', 120);
            $table->string('slug', 160);

            /**
             * Ordenação e estado.
             */
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            /**
             * Ajuda/descrição (para o “dicionário” do app).
             */
            $table->text('description')->nullable();

            $table->timestamps();

            // Índices
            $table->index(['family_id', 'type', 'is_active']);
            $table->index(['parent_id', 'type', 'is_active']);
            $table->index(['direction', 'type', 'is_active']);

            // Dedupe: dentro do mesmo escopo e tipo, slug é único.
            $table->unique(['family_id', 'type', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxonomy_nodes');
    }
};
