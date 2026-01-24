<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('name', 120);

            // Auditoria mínima de criação (nullable porque o seed/teste pode criar sem user)
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Preparado para futuro multi-moeda / preferências por família
            $table->string('currency', 3)->default('BRL');
            $table->string('timezone', 64)->default('America/Bahia');

            $table->timestamps();

            $table->index('created_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
