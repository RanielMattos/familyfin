<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulid('family_id');
            $table->foreign('family_id')->references('id')->on('families')->cascadeOnDelete();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Roles do núcleo (simples e estável)
            // OWNER, ADMIN, MEMBER, VIEWER
            $table->string('role', 20)->default('MEMBER');

            // Estado básico (preparado para convite depois)
            $table->boolean('is_active')->default(true);
            $table->timestamp('joined_at')->nullable();

            $table->timestamps();

            // Impede duplicar o mesmo usuário na mesma família
            $table->unique(['family_id', 'user_id']);

            $table->index(['family_id', 'role']);
            $table->index(['user_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
