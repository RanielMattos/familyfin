<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulid('family_id');
            $table->foreign('family_id')->references('id')->on('families')->cascadeOnDelete();

            $table->ulid('scenario_id')->nullable();
            $table->foreign('scenario_id')->references('id')->on('scenarios')->nullOnDelete();

            /**
             * Direção:
             * PAYABLE (conta a pagar) | RECEIVABLE (conta a receber)
             */
            $table->string('direction', 20);

            /**
             * Taxonomia (opcional na fase 0, mas pronta).
             */
            $table->ulid('group_node_id')->nullable();
            $table->foreign('group_node_id')->references('id')->on('taxonomy_nodes')->nullOnDelete();

            $table->ulid('category_node_id')->nullable();
            $table->foreign('category_node_id')->references('id')->on('taxonomy_nodes')->nullOnDelete();

            $table->ulid('subcategory_node_id')->nullable();
            $table->foreign('subcategory_node_id')->references('id')->on('taxonomy_nodes')->nullOnDelete();

            /**
             * Nome do compromisso:
             * ex: "Aluguel", "Internet", "Cartão Nubank", "Escola"
             */
            $table->string('name', 160);
            $table->string('slug', 180);

            /**
             * Regras de recorrência:
             * NONE | MONTHLY | WEEKLY | YEARLY | CUSTOM
             */
            $table->string('recurrence', 20)->default('MONTHLY');

            /**
             * Para mensal: day_of_month (1..31). Pode ser null se CUSTOM.
             */
            $table->unsignedTinyInteger('day_of_month')->nullable();

            /**
             * Para custom: intervalo em dias (ex: a cada 15 dias)
             */
            $table->unsignedSmallInteger('interval_days')->nullable();

            /**
             * Parcelamento: se total_installments != null, é parcelado.
             */
            $table->unsignedSmallInteger('total_installments')->nullable();

            /**
             * Valor padrão (previsto) em centavos.
             * Ocorrência pode sobrescrever.
             */
            $table->bigInteger('default_amount_cents')->default(0);

            /**
             * Controle de estado
             */
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->text('notes')->nullable();

            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['family_id', 'direction', 'is_active']);
            $table->index(['family_id', 'scenario_id']);
            $table->index(['recurrence', 'is_active']);

            // Evita duplicar a mesma conta no mesmo escopo
            $table->unique(['family_id', 'direction', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
