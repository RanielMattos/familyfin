<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bill_occurrences', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulid('bill_id');
            $table->foreign('bill_id')->references('id')->on('bills')->cascadeOnDelete();

            /**
             * Competência (opcional), sempre YYYY-MM-01.
             * Útil para relatórios e dashboard mensal.
             */
            $table->date('competence')->nullable();

            /**
             * Vencimento real do compromisso.
             */
            $table->date('due_date');

            /**
             * Parcelamento: número da parcela (1..N) quando aplicável.
             */
            $table->unsignedSmallInteger('installment_number')->nullable();

            /**
             * Valores:
             * planned = previsto; paid = efetivamente pago.
             */
            $table->bigInteger('planned_amount_cents')->default(0);
            $table->bigInteger('paid_amount_cents')->default(0);

            /**
             * Status:
             * OPEN | PAID | LATE | CANCELED
             */
            $table->string('status', 20)->default('OPEN');

            /**
             * Datas úteis
             */
            $table->date('paid_at')->nullable();

            /**
             * Campo livre pra conciliação futura (id de transação/banco).
             */
            $table->string('external_ref', 190)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['due_date', 'status']);
            $table->index(['competence', 'status']);
            $table->index(['bill_id', 'due_date']);

            // Evita duplicar o mesmo vencimento da mesma conta
            $table->unique(['bill_id', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_occurrences');
    }
};
