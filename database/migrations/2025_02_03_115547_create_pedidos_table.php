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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 8, 2);
            $table->enum('status', ['novo','em_revisao','alteracoes_solicitadas', 'aprovado', 'rejeitado'])->default('novo');
            $table->timestamp('data_criacao')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('data_atualizacao')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('solicitante_id')->constrained('users');
            $table->foreignId('grupo_id')->constrained('grupos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
