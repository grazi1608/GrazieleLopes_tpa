<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pergunta_user', function (Blueprint $table) {
            $table->id();
            
            // Chaves estrangeiras exigidas pelo Ticket #009
            $table->foreignId('pergunta_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->timestamps();

            // Impede duplicidade de votos do mesmo usuário na mesma pergunta
            $table->unique(['pergunta_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pergunta_user');
    }
};
